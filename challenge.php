<html>
<head>
	<title>Gridiron Challenge</title>
  <link rel="stylesheet" href="<?php print( plugin_dir_url( __FILE__ ).'css/challenge.css')?>"/>
</head>

<body>
<main class="archive">
	<!-- Challenger: PHP/Markup -->
  <section class="sg-gridiron">
    <!-- [TO] - Element to drag -->
    <div class="sg-gridiron__draggable">
      <p></p>
    </div>
    <div class="sg-gridiron__field">
      <div class="sg-gridiron__field-spacer">
      </div>
      <?php
        $args = array(
          'post_type'   => 'gridiron',
          'post_status' => 'publish',
          'order'=> 'ASC'
         );
        $gridiron = new WP_Query( $args );
        if( $gridiron->have_posts() ) :
      ?>
      <?php
        while( $gridiron->have_posts() ) :
          $gridiron->the_post();
          ?>
            <div class="sg-gridiron__field-element">
              <p data-content='<?php print( get_the_content() ) ?>'>
                <?php
                  // [BONUS] 3. Add the yard numbers.
                  $total_yards = 100;
                  $middle_of_field = 51;
                  $yards_on_field = preg_replace('/^0+/','', get_the_title());
                  $yards_result = ($yards_on_field < $middle_of_field) ? print($yards_on_field) : print( $total_yards - $yards_on_field);
                ?>
              </p>
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

<!-- Challenger, use of jQuery libraries is optional -->
<script src="<?php print( plugin_dir_url( __FILE__ ).'js/interact.min.js')?>"></script>
<script src="<?php print( plugin_dir_url( __FILE__ ).'js/challenge.js')?>"></script>

</script>
</body>
</html>
