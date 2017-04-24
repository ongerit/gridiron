<html>

<head>
	<title>Gridiron Challenge</title>
</head>

<body>

<main class="archive">

	<header><h1>Welcome Challenger</h1></header>

	<!-- Challenger: PHP/Markup -->

  <section class="sg-gridiron">
    <!-- [TO] - Element to drag -->
    <div class="sg-gridiron__draggable">
      <p></p>
    </div>
    <!-- [TO] - End of element to drag -->

    <div class="sg-gridiron__field">
      <div class="sg-gridiron__field-spacer">
      </div>
      <?php
      $args = array(
        'post_type'   => 'gridiron',
        'post_status' => 'publish',
        'order'=>'ASC'
       );

      $gridiron = new WP_Query( $args );
      if( $gridiron->have_posts() ) :
      ?>
      <?php
        while( $gridiron->have_posts() ) :
          $gridiron->the_post();
          ?>
            <div class="sg-gridiron__field-element">
              <p data-content='<?php print( get_the_content() ) ?>'><?php printf( '%1$s', get_the_title());  ?></p>
            </div>
          <?php
        endwhile;
        wp_reset_postdata();
      ?>
      <?php
      else :
        esc_html_e( 'No testimonials in the diving taxonomy!', 'text-domain' );
      endif;
      ?>
      <div class="sg-gridiron__field-spacer">
      </div>
    </div>
  </section>

</main>

<style>

	/* Challenger: Styles here */
  /*[BONUS]*/
  /*2. Use vh units to ensure the field is fully on screen on mobile.*/
  :root {
    --grass-stain: #8AC24A;
    --white: #FFF;
    --mango: #FDD835;
    --slate: #294661;
    --spruce: #4CB04F;
  }

  body {
      margin-top: 0;
  }

  .sg-gridiron {
    border: 5px solid var(--slate);
    max-width: 1000px;
		width: 100%;
    box-sizing: border-box;
    position: relative;
		overflow: hidden;
		// [TO] aspect ratio
		max-width: 1000px;
    height: 54.334vw;
    max-height: 54.334vh;
		background:gold;
  }

  .sg-gridiron__draggable {
    background:  var(--mango);
    border: 3px solid var(--mango);
		position: absolute;
		width: 30px;
    left: 3px;
    z-index: 3;

    // [TO] from documentation
    max-width: 30px;
    height: 30px;

    background-color: var(--mango);
    color: white;

    -webkit-transform: translate(0px, 0px);
            transform: translate(0px, 0px);
  }

  .sg-gridiron__draggable p {
		margin: 0;
		line-height: 30px;
		text-align: center;
    z-index: 3;
	}

	.sg-gridiron__draggable:after {
		content: "";
		height: 1000px;
		width: 3px;
		background-color: var(--mango);
		position:absolute;
		top: 30px;
    left: 13px;
	}

	.sg-gridiron__draggable:before {
		content: "";
		height: 1000px;
		width: 3px;
		background-color: var(--mango);
		position:absolute;
		bottom: 30px;
		left: 13px;
	}

  .sg-gridiron__field {
    background:  var(--grass-stain);
    border: 3px solid var(--white);
    height: 100%;
    display: flex;
		box-sizing: border-box;
  }

  .sg-gridiron__field-spacer {
    background: var(--spruce);
    border-right: 1px solid var(--white);
    width: 20%;
  }

  .sg-gridiron__field-element {
    background: var(--grass-stain);
    border-right: 1px solid var(--white);
    width: 20%;
    position: relative;
  }

  .sg-gridiron__field-element p {
    color: var(--white);
    font-size: 25px;
    bottom: 15%;
    position: absolute;
    left: 43%;
    letter-spacing: 3px;
    z-index: 2;
  }

</style>

<!-- Challenger, use of jQuery libraries is optional -->
<!-- <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
<script src="http://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script> -->
<script src="//cdnjs.cloudflare.com/ajax/libs/interact.js/1.2.8/interact.min.js"></script>
<script>

	/* Challenger: Javascript here */
  //[BONUS]*/
  //3. Add the yard numbers.

  // target elements with the "draggable" class
interact('.sg-gridiron__draggable')
  .draggable({
    // enable inertial throwing
    inertia: true,
    // keep the element within the area of it's parent
    restrict: {
      restriction: "parent",
      endOnly: true,
      elementRect: { top: 0, left: 0, bottom: 1, right: 1 }
    },
    // enable autoScroll
    autoScroll: true,

    // call this function on every dragmove event
    onmove: dragMoveListener,
    // call this function on every dragend event
    onend: function (event) {
      var textEl = event.target.querySelector('p');
			var numberOfFieldElements = 10;
      // [TO] Width of the page
      var fieldWidth = document.querySelector('.sg-gridiron__field-element').clientWidth * numberOfFieldElements;
      var elementDistance = event.clientX;
      var fieldValue = Math.round(elementDistance/fieldWidth * 100)-10;
      // [TO] offset because of
      // the 3px border
      var calibrator = 3;

      if(fieldValue - calibrator < 0 || fieldValue > 103) {
        textEl.textContent = '';
        return;
      }
      textEl.textContent = fieldValue - calibrator;
    }
  });

  function dragMoveListener (event) {
    var target = event.target,
        // keep the dragged position in the data-x/data-y attributes
        x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx,
        y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;
    // translate the element
    target.style.webkitTransform =
    target.style.transform =
      'translate(' + x + 'px, ' + y + 'px)';
    // update the posiion attributes
    target.setAttribute('data-x', x);
    target.setAttribute('data-y', y);
  }
  // this is used later in the resizing and gesture demos
  window.dragMoveListener = dragMoveListener;
</script>

</body>

</html>
