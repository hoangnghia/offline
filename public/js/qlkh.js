 function toggleClass(targetElement, addedClass) {
  if (targetElement.classList.contains(addedClass)) {
    targetElement.classList.remove(addedClass);
  }
  else {
    targetElement.classList.add(addedClass);
  }
};
document.querySelector('.menu-btn').addEventListener('click', function() {
  toggleClass(document.querySelector('.menu'), 'menu--open');
  toggleClass(document.querySelector('.menu-btn'), 'menu-btn--on');
});