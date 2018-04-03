<?php
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('parent-style')
    );
}
function custom_post_type() {
 
// Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'Фильмы', 'Post Type General Name', 'twentyseventeen' ),
        'singular_name'       => _x( 'Фильм', 'Post Type Singular Name', 'twentyseventeen' ),
        'menu_name'           => __( 'Фильмы', 'twentyseventeen' ),
        'parent_item_colon'   => __( 'Parent Movie', 'twentyseventeen' ),
        'all_items'           => __( 'Все фильмы', 'twentyseventeen' ),
        'view_item'           => __( 'Просмотр фильма', 'twentyseventeen' ),
        'add_new_item'        => __( 'Добавить новый фильм', 'twentyseventeen' ),
        'add_new'             => __( 'Добавить Новый', 'twentyseventeen' ),
        'edit_item'           => __( 'Редактировать фильм', 'twentyseventeen' ),
        'update_item'         => __( 'Обновить фильм', 'twentyseventeen' ),
        'search_items'        => __( 'Поиск фильма', 'twentyseventeen' ),
        'not_found'           => __( 'Такого фильма в архиве не обнаружено', 'twentyseventeen' ),
        'not_found_in_trash'  => __( 'Нет фильмов в корзине', 'twentyseventeen' ),
    );
     
// Set other options for Custom Post Type
     
    $args = array(
        'label'               => __( 'movies', 'twentyseventeen' ),
        'description'         => __( 'Фильмы', 'twentyseventeen' ),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
        // You can associate this CPT with a taxonomy or custom taxonomy. 
        'taxonomies'          => array( 'genres' ),
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */ 
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );
     
    // Registering Custom Post Type
    register_post_type( 'movies', $args );
 
}
 
/* Hook into the 'init' action so that the function
* Containing our post type registration is not 
* unnecessarily executed. 
*/
 
add_action( 'init', 'custom_post_type', 0 );
//hook into the init action and call create_topics_nonhierarchical_taxonomy when it fires
 //hook into the init action and call create_book_taxonomies when it fires

add_action( 'init', 'create_years_nonhierarchical_taxonomy', 0 );
 
function create_years_nonhierarchical_taxonomy() {
 
// Labels part for the GUI
 
  $labels = array(
    'name' => _x( 'Год выпуска', 'taxonomy general name' ),
    'singular_name' => _x( 'Год фильма', 'taxonomy singular name' ),
    'search_items' =>  __( 'Поиск по году выпуска' ),
    'popular_items' => __( 'Популярные годы' ),
    'all_items' => __( 'Все годы выпуска' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Редактировать год' ), 
    'update_item' => __( 'Обновить год' ),
    'add_new_item' => __( 'Добавить новый год' ),
    'new_item_name' => __( 'Год выпуска фильма' ),
    'separate_items_with_commas' => __( 'премьера фильма' ),
    'add_or_remove_items' => __( 'добавить или удалить год фильма' ),
    'choose_from_most_used' => __( 'Выбирайте год фильма' ),
    'menu_name' => __( 'Год' ),
  ); 
 
  register_taxonomy('years','movies',array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'update_count_callback' => '_update_movies_term_count',
    'query_var' => true,
    'rewrite' => array( 'slug' => 'year' ),
  ));
}


add_action( 'init', 'create_genres_nonhierarchical_taxonomy', 0 );
 
function create_genres_nonhierarchical_taxonomy() {
 
// Labels part for the GUI
 
  $labels = array(
    'name' => _x( 'Жанры', 'taxonomy general name' ),
    'singular_name' => _x( 'Жанр фильма', 'taxonomy singular name' ),
    'search_items' =>  __( 'Поиск по жанру выпуска' ),
    'popular_items' => __( 'Популярные жанры' ),
    'all_items' => __( 'Все жанры' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Редактировать жанр' ), 
    'update_item' => __( 'Обновить жанр' ),
    'add_new_item' => __( 'Добавить новый жанр' ),
    'new_item_name' => __( 'Жанр фильма' ),
    'separate_items_with_commas' => __( 'Выберите или введите жанры фильма' ),
    'add_or_remove_items' => __( 'добавить или удалить жанр фильма' ),
    'choose_from_most_used' => __( 'Выбирайте жанр фильма' ),
    'menu_name' => __( 'Жанр' ),
  ); 
 
  register_taxonomy('genres','movies',array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'update_count_callback' => '_update_movies_term_count',
    'query_var' => true,
    'rewrite' => array( 'slug' => 'genre' ),
  ));
}
add_action( 'pre_get_posts', 'add_my_post_types_to_query' );
 
function add_my_post_types_to_query( $query ) {
    if ( is_home() && $query->is_main_query() )
        $query->set( 'post_type', array( 'post', 'movies' ) );
    return $query;
}
// Add the custom field "skype"
add_action( 'woocommerce_edit_account_form', 'add_skype_to_edit_account_form' );
function add_skype_to_edit_account_form() {
    $user = wp_get_current_user();
    ?>
        <label for="skype"><?php _e( 'Skype', 'woocommerce' ); ?>
        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="skype" id="skype" value="<?php echo esc_attr( $user->skype ); ?>" />
    <?php
}
add_action( 'woocommerce_save_account_details', 'save_skype_account_details', 12, 1 );
function save_skype_account_details( $user_id ) {
    // For skype
    if( isset( $_POST['skype'] ) )
        update_user_meta( $user_id, 'skype', sanitize_text_field( $_POST['skype'] ) );

    // For Billing email (added related to your comment)
    if( isset( $_POST['account_email'] ) )
        update_user_meta( $user_id, 'billing_email', sanitize_text_field( $_POST['account_email'] ) );
}
function wooc_extra_register_fields() {?>
<label for="skype">Skype</label><input type="text" class="input-text" placeholder="Enter  your Skype" name="billing_skype" id="reg_billing_skype" value="<?php esc_attr_e( $_POST['billing_skype'] ); ?>" /><br />
<?php
 }
add_action( 'woocommerce_register_form_start', 'wooc_extra_register_fields' );
function my_custom_add_to_cart_redirect( $url ) {
	$url = 'https://wplab.us/test/cart/?startcheckout=true'; // URL to redirect to (1 is the page ID here)
	return $url;
}
add_filter( 'woocommerce_add_to_cart_redirect', 'my_custom_add_to_cart_redirect' );
function custom_registration_redirect() {
    wp_logout();
    return home_url('/movies/');
}
add_action('woocommerce_registration_redirect', 'custom_registration_redirect', 2);