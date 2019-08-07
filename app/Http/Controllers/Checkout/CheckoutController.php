<?php

namespace App\Http\Controllers\Checkout;

use App\Shop\Addresses\Repositories\Interfaces\AddressRepositoryInterface;
use App\Shop\Cart\Requests\CartCheckoutRequest;
use App\Shop\Carts\Repositories\Interfaces\CartRepositoryInterface;
use App\Shop\Carts\Requests\PayPalCheckoutExecutionRequest;
use App\Shop\Carts\Requests\StripeExecutionRequest;
use App\Shop\Couriers\Repositories\Interfaces\CourierRepositoryInterface;
use App\Shop\Customers\Customer;
use App\Shop\Customers\Repositories\CustomerRepository;
use App\Shop\Customers\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Shop\Orders\OrderPayment;
use App\Shop\Orders\Repositories\Interfaces\OrderRepositoryInterface;
use App\Shop\PaymentMethods\Paypal\Exceptions\PaypalRequestError;
use App\Shop\PaymentMethods\Paypal\Repositories\PayPalExpressCheckoutRepository;
use App\Shop\PaymentMethods\Stripe\Exceptions\StripeChargingErrorException;
use App\Shop\PaymentMethods\Stripe\StripeRepository;
use App\Shop\Products\Repositories\Interfaces\ProductRepositoryInterface;
use App\Shop\Products\Transformations\ProductTransformable;
use App\Shop\Shipping\ShippingInterface;
use Exception;
use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use PayPal\Exception\PayPalConnectionException;

class CheckoutController extends Controller
{
    use ProductTransformable;

    /**
     * @var CartRepositoryInterface
     */
    private $cartRepo;

    /**
     * @var CourierRepositoryInterface
     */
    private $courierRepo;

    /**
     * @var AddressRepositoryInterface
     */
    private $addressRepo;

    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepo;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepo;

    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepo;

    /**
     * @var PayPalExpressCheckoutRepository
     */
    private $payPal;

    /**
     * @var ShippingInterface
     */
    private $shippingRepo;

    public function __construct(
        CartRepositoryInterface $cartRepository,
        CourierRepositoryInterface $courierRepository,
        AddressRepositoryInterface $addressRepository,
        CustomerRepositoryInterface $customerRepository,
        ProductRepositoryInterface $productRepository,
        OrderRepositoryInterface $orderRepository,
        ShippingInterface $shipping
    )
    {
        $this->cartRepo = $cartRepository;
        $this->courierRepo = $courierRepository;
        $this->addressRepo = $addressRepository;
        $this->customerRepo = $customerRepository;
        $this->productRepo = $productRepository;
        $this->orderRepo = $orderRepository;
        $this->payPal = new PayPalExpressCheckoutRepository;
        $this->shippingRepo = $shipping;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = $this->cartRepo->getCartItemsTransformed();
        $customer = $request->user();
        $rates = null;
        $shipment_object_id = null;

        if (env('ACTIVATE_SHIPPING') == 1) {
            $shipment = $this->createShippingProcess($customer, $products);
            if (!is_null($shipment)) {
                $shipment_object_id = $shipment->object_id;
                $rates = $shipment->rates;
            }
        }
        // Get payment gateways
        $paymentGateways = collect(explode(',', config('payees.name')))->transform(function ($name) {
            return config($name);
        })->all();
        $cartCountItems = $this->cartRepo->countItems();
        return view('front.checkout', [
            'customer' => $customer,
            'products' => $this->cartRepo->getCartItemsTransformed(),
            'subtotal' => $this->cartRepo->getSubTotal(),
            'tax' => $this->cartRepo->getTax(),
            'cartCountItems' => $cartCountItems,
            'total' => $this->cartRepo->getSubTotal(),
            'payments' => $paymentGateways,
            'cartItems' => $this->cartRepo->getCartItemsTransformed(),
            'productsHome' => $this->cartRepo->getCartItemsTransformed(),
            'shipment_object_id' => $shipment_object_id,
            'rates' => $rates
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function checkout(Request $request)
    {
        $products = $this->cartRepo->getCartItemsTransformed();
        $customer = $request->user();
        $rates = null;
        $shipment_object_id = null;

        if (env('ACTIVATE_SHIPPING') == 1) {
            $shipment = $this->createShippingProcess($customer, $products);
            if (!is_null($shipment)) {
                $shipment_object_id = $shipment->object_id;
                $rates = $shipment->rates;
            }
        }
        // Get payment gateways
        $paymentGateways = collect(explode(',', config('payees.name')))->transform(function ($name) {
            return config($name);
        })->all();
        $billingAddress = $customer->addresses()->first();

        return view('front.checkout', [
            'customer' => $customer,
            'billingAddress' => $billingAddress,
            'addresses' => $customer->addresses()->get(),
            'products' => $this->cartRepo->getCartItemsTransformed(),
            'subtotal' => $this->cartRepo->getSubTotal(),
            'tax' => $this->cartRepo->getTax(),
            'total' => $this->cartRepo->getSubTotal(),
            'payments' => $paymentGateways,
            'cartItems' => $this->cartRepo->getCartItemsTransformed(),
            'shipment_object_id' => $shipment_object_id,
            'rates' => $rates
        ]);
    }


    /**
     * Checkout the items
     *
     * @param CartCheckoutRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Shop\Addresses\Exceptions\AddressNotFoundException
     * @throws \App\Shop\Customers\Exceptions\CustomerPaymentChargingErrorException
     * @codeCoverageIgnore
     */
    public function store(CartCheckoutRequest $request)
    {
        $shippingFee = 0;

        switch ($request->input('payment')) {
            case 'paypal':
                return $this->payPal->process($shippingFee, $request);
                break;
            case 'stripe':

                $details = [
                    'description' => 'Stripe payment',
                    'metadata' => $this->cartRepo->getCartItems()->all()
                ];

                $customer = $this->customerRepo->findCustomerById(auth()->id());
                $customerRepo = new CustomerRepository($customer);
                $customerRepo->charge($this->cartRepo->getTotal(2, $shippingFee), $details);
                break;
            default:
        }
    }

    /**
     * Execute the PayPal payment
     *
     * @param PayPalCheckoutExecutionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function executePayPalPayment(PayPalCheckoutExecutionRequest $request)
    {
        try {
            $this->payPal->execute($request);
            $this->cartRepo->clearCart();

            return redirect()->route('checkout.success');
        } catch (PayPalConnectionException $e) {
            throw new PaypalRequestError($e->getData());
        } catch (Exception $e) {
            throw new PaypalRequestError($e->getMessage());
        }
    }

    /**
     * @param StripeExecutionRequest $request
     * @return \Stripe\Charge
     */
    public function charge(StripeExecutionRequest $request)
    {
        try {
            $customer = $this->customerRepo->findCustomerById(auth()->id());
            $stripeRepo = new StripeRepository($customer);

            $stripeRepo->execute(
                $request->all(),
                Cart::total(),
                Cart::tax()
            );
            return redirect()->route('checkout.success')->with('message', 'Stripe payment successful!');
        } catch (StripeChargingErrorException $e) {
            Log::info($e->getMessage());
            return redirect()->route('checkout.index')->with('error', 'There is a problem processing your request.');
        }
    }

    /**
     * Cancel page
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function cancel(Request $request)
    {
        return view('front.checkout-cancel', ['data' => $request->all()]);
    }

    /**
     * Success page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function success()
    {
        return view('front.checkout-success');
    }

    public function process(Request $request){

        $orderPayment = new OrderPayment();
        $orderPayment->partner_code = isset($request->partnerCode) ? $request->partnerCode : '';
        $orderPayment->access_key = isset($request->accessKey) ? $request->accessKey : '';
        $orderPayment->request_id = isset($request->requestId) ? $request->requestId : '';
        $orderPayment->amount = isset($request->amount) ? $request->amount : '';
        $orderPayment->order_id = isset($request->orderId) ? $request->orderId : '';
        $orderPayment->order_info = isset($request->orderInfo) ? $request->orderInfo : '';
        $orderPayment->order_type = isset($request->orderType) ? $request->orderType : '';
        $orderPayment->trans_id = isset($request->transId) ? $request->transId : '';
        $orderPayment->message = isset($request->message) ? $request->message : '';
        $orderPayment->local_message = isset($request->localMessage) ? $request->localMessage : '';
        $orderPayment->response_time = isset($request->responseTime) ? $request->responseTime : '';
        $orderPayment->error_code = isset($request->errorCode) ? $request->errorCode : '';
        $orderPayment->pay_type = isset($request->payType) ? $request->payType : '';
        $orderPayment->signature = isset($request->signature) ? $request->signature : '';
        $orderPayment->save();

        if(!$orderPayment instanceof OrderPayment || $orderPayment->error_code > 0){
            $errorMsg = !is_null($orderPayment->local_message) ? $orderPayment->local_message : 'Có lỗi xảy ra, vui lòng kiểm tra lại!';
            return redirect()->route('checkout.index', $request->all())->with('error', $errorMsg);
        }else{
            Cart::destroy();
            return redirect()->route('checkout.success');
        }

    }

    /**
     * @param Customer $customer
     * @param Collection $products
     *
     * @return mixed
     */
    private function createShippingProcess(Customer $customer, Collection $products)
    {
        $customerRepo = new CustomerRepository($customer);

        if ($customerRepo->findAddresses()->count() > 0 && $products->count() > 0) {

            $this->shippingRepo->setPickupAddress();
            $deliveryAddress = $customerRepo->findAddresses()->first();
            $this->shippingRepo->setDeliveryAddress($deliveryAddress);
            $this->shippingRepo->readyParcel($this->cartRepo->getCartItems());

            return $this->shippingRepo->readyShipment();
        }
    }
}
