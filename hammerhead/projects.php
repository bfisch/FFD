<?php
/*
Developed by: Eddie Machado
URL: http://themble.com/backspin/
*/

// // Flush rewrite rules for custom post types
// add_action( 'after_switch_theme', 'backspin_flush_rewrite_rules' );

// // Flush your rewrite rules
// function backspin_flush_rewrite_rules() {
// 	flush_rewrite_rules();
// }

function projects_cpt() { 

	register_post_type( 'projects', /* All Fields with this tag must match - currently 'projects' */

		array(
			'labels' => array(
				'name' => __( 'Projects', 'hammerhead' ), /* This is the Title of the Group */
				'singular_name' => __( 'Project', 'hammerhead' ), /* This is the individual type */
				'all_items' => __( 'All Projects', 'hammerhead' ), /* the all items menu item */
				'add_new' => __( 'Add New', 'hammerhead' ), /* The add new menu item */
				'add_new_item' => __( 'Add New Project', 'hammerhead' ), /* Add New Display Title */
				'edit' => __( 'Edit', 'hammerhead' ), /* Edit Dialog */
				'edit_item' => __( 'Edit Project', 'hammerhead' ), /* Edit Display Title */
				'new_item' => __( 'New Project', 'hammerhead' ), /* New Display Title */
				'view_item' => __( 'View Project', 'hammerhead' ), /* View Display Title */
				'search_items' => __( 'Search Projects', 'hammerhead' ), /* Search Custom Type Title */ 
				'not_found' =>  __( 'No projects found in the Database.', 'hammerhead' ), /* This displays if there are no entries yet */ 
				'not_found_in_trash' => __( 'No projects found in Trash', 'hammerhead' ), /* This displays if there is nothing in the trash */
				'parent_item_colon' => ''
			),

			'description' => __( 'This is the example projects post type', 'hammerhead' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 2, /* this is what order you want it to appear in on the left hand side menu */ 
			'menu_icon' => 'dashicons-screenoptions', /* the icon for the projects post type menu */
			'rewrite'	=> array( 'slug' => 'projects', 'with_front' => false ), /* you can specify its url slug */ /* All Fields with this tag must match - currently 'projects' */
			'has_archive' => 'projects', /* you can rename the slug here */ /* All Fields with this tag must match - currently 'projects' */
			'capability_type' => 'post',
			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array(
				'title',
				'editor',
				//'author',
				'thumbnail',
				//'excerpt',
				//'trackbacks',
				'page-attributes',
				'custom-fields',
				//'comments',
				//'revisions',
				'sticky'
			)
		)
	);
}

add_action( 'init', 'projects_cpt');

register_taxonomy( 'projects_category', 
	array('projects'), /* if you change the name of register_post_type( 'projects', then you have to change this */ /* All Fields with this tag must match - currently 'projects' */
	array('hierarchical' => true,     /* if this is true, it acts like categories */
		'labels' => array(
			'name' => __( 'Categories', 'hammerhead' ), /* name of the projects taxonomy */
			'singular_name' => __( 'Category', 'hammerhead' ), /* single taxonomy name */
			'search_items' =>  __( 'Search Categories', 'hammerhead' ), /* search title for taxomony */
			'all_items' => __( 'All Categories', 'hammerhead' ), /* all title for taxonomies */
			'parent_item' => __( 'Parent Category', 'hammerhead' ), /* parent title for taxonomy */
			'parent_item_colon' => __( 'Parent Category:', 'hammerhead' ), /* parent taxonomy title */
			'edit_item' => __( 'Edit Category', 'hammerhead' ), /* edit projects taxonomy title */
			'update_item' => __( 'Update Category', 'hammerhead' ), /* update title for taxonomy */
			'add_new_item' => __( 'Add New Category', 'hammerhead' ), /* add new title for taxonomy */
			'new_item_name' => __( 'New Category Name', 'hammerhead' ) /* name title for taxonomy */
		),
		'show_admin_column' => true, 
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'projects-slug' ),
	)
);

/* Metabox Setup */

add_action( 'load-post.php', 'projects_meta_box_setup' );
add_action( 'load-post-new.php', 'projects_meta_box_setup' );

function projects_meta_box_setup() {
  add_action( 'add_meta_boxes', 'add_price_meta_box' );

  add_action( 'save_post', 'save_price_meta_box', 10, 2 );
}

function add_price_meta_box() {

  add_meta_box(
    'project-price',      // Unique ID
    esc_html__( 'Price' ),    // Title
    'project_price_meta_box',   // Callback function
    'projects',         // Admin page (or post type)
    'normal',         // Context
    'default'         // Priority
  );
}

/* Display the post meta box. */
function project_price_meta_box( $object, $box ) { ?>

  <?php wp_nonce_field( basename( __FILE__ ), 'project_price_nonce' ); ?>

  <p>
    <input class="widefat" type="text" name="project-price" id="project-price" value="<?php echo esc_attr( get_post_meta( $object->ID, 'project_price', true ) ); ?>" size="30" />
  </p>
<?php }

/* Save the meta box's post metadata. */
function save_price_meta_box( $post_id, $post ) {

  /* Verify the nonce before proceeding. */
  if ( !isset( $_POST['project_price_nonce'] ) || !wp_verify_nonce( $_POST['project_price_nonce'], basename( __FILE__ ) ) )
    return $post_id;

  /* Get the post type object. */
  $post_type = get_post_type_object( $post->post_type );

  /* Check if the current user has permission to edit the post. */
  if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
    return $post_id;

  /* Get the posted data and sanitize it for use as an HTML class. */
  //$new_meta_value = ( isset( $_POST['project-price'] ) ? sanitize_html_class( $_POST['project-price'] ) : '' );
  $new_meta_value = $_POST['project-price'];

  /* Get the meta key. */
  $meta_key = 'project_price';

  /* Get the meta value of the custom field key. */
  $meta_value = get_post_meta( $post_id, $meta_key, true );

  /* If a new meta value was added and there was no previous value, add it. */
  if ( $new_meta_value && '' == $meta_value )
    add_post_meta( $post_id, $meta_key, $new_meta_value, true );

  /* If the new meta value does not match the old value, update it. */
  elseif ( $new_meta_value && $new_meta_value != $meta_value )
    update_post_meta( $post_id, $meta_key, $new_meta_value );

  /* If there is no new meta value but an old value exists, delete it. */
  elseif ( '' == $new_meta_value && $meta_value )
    delete_post_meta( $post_id, $meta_key, $meta_value );
}

	
/**
* add order column to admin listing screen for header text
*/
function add_new_projects_column($projects_columns) {
  $projects_columns['menu_order'] = "Order";
  return $projects_columns;
}
add_action('manage_edit-projects_columns', 'add_new_projects_column');


/**
* show custom order column values
*/
function show_order_column($name){
  global $post;

  switch ($name) {
    case 'menu_order':
      $order = $post->menu_order;
      echo $order;
      break;
   default:
      break;
   }
}
add_action('manage_projects_posts_custom_column','show_order_column');


/**
* make column sortable
*/
function order_column_register_sortable($columns){
  $columns['menu_order'] = 'menu_order';
  return $columns;
}
add_filter('manage_edit-projects_sortable_columns','order_column_register_sortable');

?>
