<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<h1 class="shin"><?php if ( get_field('shin') ) : ?>
    <span> <?php the_field('shin') ?></span>
<?php endif; ?>
</h1>

<input type="number" name="shin-tele" id="shin">