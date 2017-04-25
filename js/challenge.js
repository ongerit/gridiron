/* Challenger: Javascript here */
// [TO] target elements with the "draggable" class
interact('.sg-gridiron__draggable').draggable({
    // enable inertial throwing
    inertia: true,
    // keep the element within the area of it's parent
    restrict: {
        restriction: "parent",
        endOnly: true,
        elementRect: {
            top: 0,
            left: 0,
            bottom: 1,
            right: 1
        }
    },
    // enable autoScroll
    autoScroll: true,
    // call this function on every dragmove event
    onmove: dragMoveListener,
    // call this function on every dragend event
    onend: function(event) {
        var textEl = event.target.querySelector('p');
        var numberOfFieldElements = 10;
        // [TO] Width of the page
        var fieldWidth = document.querySelector('.sg-gridiron__field-element').offsetWidth * numberOfFieldElements;
        var elementDistance = event.clientX;
        var fieldValue = Math.round(elementDistance / fieldWidth * 100) - numberOfFieldElements;
        // [TO] offset because of
        // the 5px border
        var calibrator = 4;

        // [TO] return no value
        // when yards on feild are
        // a negative number or over 100 yards.
        if (fieldValue - calibrator < 0 || fieldValue > 104) {
            textEl.textContent = '';
            return;
        }

        // [TO] decrease yards
        // once user is past 50 yards
        if (fieldValue - calibrator > 50) {
            textEl.textContent = (fieldWidth / fieldWidth) * 100 - (fieldValue - calibrator);
            return;
        }

        textEl.textContent = fieldValue - calibrator;
    }
});

function dragMoveListener(event) {
    var target = event.target,
    // keep the dragged position in the data-x/data-y attributes
    x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx,
    y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;
    // translate the element
    target.style.webkitTransform = target.style.transform = 'translate(' + x + 'px, ' + y + 'px)';
    // update the posiion attributes
    target.setAttribute('data-x', x);
    target.setAttribute('data-y', y);
}
// this is used later in the resizing and gesture demos
window.dragMoveListener = dragMoveListener;
