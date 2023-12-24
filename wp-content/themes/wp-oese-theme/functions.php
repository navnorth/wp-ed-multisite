<?php
/**
 * OESE functions and definitions
 *
 * Sets up the theme and provides some helper functions, which are used
 * in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 */
define( "WP_OESE_THEME_NAME", "WP OESE Theme" );
define( "WP_OESE_THEME_VERSION", "2.2.1" );
define( "WP_OESE_THEME_SLUG", "wp_oese_theme" );
global $_nalrc;

// Set up the content width value based on the theme's design and stylesheet.
if ( ! isset( $content_width ) ) {
    $content_width = 625;
}

/**
 * Twenty Twelve setup.
 *
 * Sets up theme defaults and registers the various WordPress features that
 * Twenty Twelve supports.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To add a Visual Editor stylesheet.
 * @uses add_theme_support() To add support for post thumbnails, automatic feed links,
 *  custom background, and post formats.
 * @uses register_nav_menu() To add support for navigation menus.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_setup() {
  /*
   * Makes Twenty Twelve available for translation.
   *
   * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/twentytwelve
   * If you're building a theme based on Twenty Twelve, use a find and replace
   * to change 'twentytwelve' to the name of your theme in all the template files.
   */
  load_theme_textdomain( 'twentytwelve' );

  // This theme styles the visual editor with editor-style.css to match the theme style.
  add_editor_style();

  // Load regular editor styles into the new block-based editor.
  add_theme_support( 'editor-styles' );

  // Load default block styles.
  add_theme_support( 'wp-block-styles' );

  // Add support for responsive embeds.
  add_theme_support( 'responsive-embeds' );

  // Add support for custom color scheme.
  add_theme_support(
    'editor-color-palette',
    array(
      array(
        'name'  => __( 'Blue', 'twentytwelve' ),
        'slug'  => 'blue',
        'color' => '#21759b',
      ),
      array(
        'name'  => __( 'Dark Gray', 'twentytwelve' ),
        'slug'  => 'dark-gray',
        'color' => '#444',
      ),
      array(
        'name'  => __( 'Medium Gray', 'twentytwelve' ),
        'slug'  => 'medium-gray',
        'color' => '#9f9f9f',
      ),
      array(
        'name'  => __( 'Light Gray', 'twentytwelve' ),
        'slug'  => 'light-gray',
        'color' => '#e6e6e6',
      ),
      array(
        'name'  => __( 'White', 'twentytwelve' ),
        'slug'  => 'white',
        'color' => '#fff',
      ),
    )
  );

  // Adds RSS feed links to <head> for posts and comments.
  add_theme_support( 'automatic-feed-links' );

  // This theme supports a variety of post formats.
  add_theme_support( 'post-formats', array( 'aside', 'image', 'link', 'quote', 'status' ) );

  // This theme uses wp_nav_menu() in one location.
  register_nav_menu( 'primary', __( 'Primary Menu', 'twentytwelve' ) );

  /*
   * This theme supports custom background color and image,
   * and here we also set up the default background color.
   */
  add_theme_support(
    'custom-background',
    array(
      'default-color' => 'e6e6e6',
    )
  );

  // This theme uses a custom image size for featured images, displayed on "standard" posts.
  add_theme_support( 'post-thumbnails' );
  set_post_thumbnail_size( 624, 9999 ); // Unlimited height, soft crop

  // Indicate widget sidebars can use selective refresh in the Customizer.
  add_theme_support( 'customize-selective-refresh-widgets' );
}
add_action( 'after_setup_theme', 'twentytwelve_setup' );

/**
 * Add support for a custom header image.
 */
require( get_template_directory() . '/inc/custom-header.php' );

/**
 * Return the Google font stylesheet URL if available.
 *
 * The use of Open Sans by default is localized. For languages that use
 * characters not supported by the font, the font can be disabled.
 *
 * @since Twenty Twelve 1.2
 *
 * @return string Font stylesheet or empty string if disabled.
 */
function twentytwelve_get_font_url() {
  $font_url = '';

  /* translators: If there are characters in your language that are not supported
   * by Open Sans, translate this to 'off'. Do not translate into your own language.
   */
  if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'twentytwelve' ) ) {
    $subsets = 'latin,latin-ext';

    /* translators: To add an additional Open Sans character subset specific to your language,
     * translate this to 'greek', 'cyrillic' or 'vietnamese'. Do not translate into your own language.
     */
    $subset = _x( 'no-subset', 'Open Sans font: add new subset (greek, cyrillic, vietnamese)', 'twentytwelve' );

    if ( 'cyrillic' == $subset ) {
      $subsets .= ',cyrillic,cyrillic-ext';
    } elseif ( 'greek' == $subset ) {
      $subsets .= ',greek,greek-ext';
    } elseif ( 'vietnamese' == $subset ) {
      $subsets .= ',vietnamese';
    }

    $query_args = array(
      'family' => 'Open+Sans:400italic,700italic,400,700',
      'subset' => $subsets,
    );
    $font_url   = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
  }

  return $font_url;
}

/**
 * Enqueue scripts and styles for front end.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_scripts_styles() {
  global $wp_styles;

  /*
   * Adds JavaScript to pages with the comment form to support
   * sites with threaded comments (when in use).
   */
  if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
    wp_enqueue_script( 'comment-reply' );
  }

  // Adds JavaScript for handling the navigation menu hide-and-show behavior.
  wp_enqueue_script( 'twentytwelve-navigation', get_template_directory_uri() . '/js/navigation.js', array( 'jquery' ), '20140711', true );

  $font_url = twentytwelve_get_font_url();
  if ( ! empty( $font_url ) ) {
    wp_enqueue_style( 'twentytwelve-fonts', esc_url_raw( $font_url ), array(), null );
  }

  // Loads our main stylesheet.
  wp_enqueue_style( 'twentytwelve-style', get_stylesheet_uri() );

  // Theme block stylesheet.
  wp_enqueue_style( 'twentytwelve-block-style', get_template_directory_uri() . '/css/blocks.css', array( 'twentytwelve-style' ), '20181230' );

  // Loads the Internet Explorer specific stylesheet.
  wp_enqueue_style( 'twentytwelve-ie', get_template_directory_uri() . '/css/ie.css', array( 'twentytwelve-style' ), '20121010' );
  $wp_styles->add_data( 'twentytwelve-ie', 'conditional', 'lt IE 9' );
}
add_action( 'wp_enqueue_scripts', 'twentytwelve_scripts_styles' );

/**
 * Enqueue styles for the block-based editor.
 *
 * @since Twenty Twelve 2.6
 */
function twentytwelve_block_editor_styles() {
  // Block styles.
  wp_enqueue_style( 'twentytwelve-block-editor-style', get_template_directory_uri() . '/css/editor-blocks.css', array(), '20181230' );
  // Add custom fonts.
  wp_enqueue_style( 'twentytwelve-fonts', twentytwelve_get_font_url(), array(), null );
}
add_action( 'enqueue_block_editor_assets', 'twentytwelve_block_editor_styles' );

/**
 * Add preconnect for Google Fonts.
 *
 * @since Twenty Twelve 2.2
 *
 * @param array   $urls          URLs to print for resource hints.
 * @param string  $relation_type The relation type the URLs are printed.
 * @return array URLs to print for resource hints.
 */
function twentytwelve_resource_hints( $urls, $relation_type ) {
  if ( wp_style_is( 'twentytwelve-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
    if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '>=' ) ) {
      $urls[] = array(
        'href' => 'https://fonts.gstatic.com',
        'crossorigin',
      );
    } else {
      $urls[] = 'https://fonts.gstatic.com';
    }
  }

  return $urls;
}
add_filter( 'wp_resource_hints', 'twentytwelve_resource_hints', 10, 2 );

/**
 * Filter TinyMCE CSS path to include Google Fonts.
 *
 * Adds additional stylesheets to the TinyMCE editor if needed.
 *
 * @uses twentytwelve_get_font_url() To get the Google Font stylesheet URL.
 *
 * @since Twenty Twelve 1.2
 *
 * @param string $mce_css CSS path to load in TinyMCE.
 * @return string Filtered CSS path.
 */
function twentytwelve_mce_css( $mce_css ) {
  $font_url = twentytwelve_get_font_url();

  if ( empty( $font_url ) ) {
    return $mce_css;
  }

  if ( ! empty( $mce_css ) ) {
    $mce_css .= ',';
  }

  $mce_css .= esc_url_raw( str_replace( ',', '%2C', $font_url ) );

  return $mce_css;
}
add_filter( 'mce_css', 'twentytwelve_mce_css' );

/**
 * Filter the page title.
 *
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 *
 * @since Twenty Twelve 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string Filtered title.
 */
function twentytwelve_wp_title( $title, $sep ) {
  global $paged, $page;

  if ( is_feed() ) {
    return $title;
  }

  // Add the site name.
  $title .= get_bloginfo( 'name', 'display' );

  // Add the site description for the home/front page.
  $site_description = get_bloginfo( 'description', 'display' );
  if ( $site_description && ( is_home() || is_front_page() ) ) {
    $title = "$title $sep $site_description";
  }

  // Add a page number if necessary.
  if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
    $title = "$title $sep " . sprintf( __( 'Page %s', 'twentytwelve' ), max( $paged, $page ) );
  }

  return $title;
}
add_filter( 'wp_title', 'twentytwelve_wp_title', 10, 2 );

/**
 * Filter the page menu arguments.
 *
 * Makes our wp_nav_menu() fallback -- wp_page_menu() -- show a home link.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_page_menu_args( $args ) {
  if ( ! isset( $args['show_home'] ) ) {
    $args['show_home'] = true;
  }
  return $args;
}
add_filter( 'wp_page_menu_args', 'twentytwelve_page_menu_args' );

/**
 * Register sidebars.
 *
 * Registers our main widget area and the front page widget areas.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_widgets_init() {
  register_sidebar(
    array(
      'name'          => __( 'Main Sidebar', 'twentytwelve' ),
      'id'            => 'sidebar-1',
      'description'   => __( 'Appears on posts and pages except the optional Front Page template, which has its own widgets', 'twentytwelve' ),
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget'  => '</aside>',
      'before_title'  => '<h3 class="widget-title">',
      'after_title'   => '</h3>',
    )
  );

  register_sidebar(
    array(
      'name'          => __( 'First Front Page Widget Area', 'twentytwelve' ),
      'id'            => 'sidebar-2',
      'description'   => __( 'Appears when using the optional Front Page template with a page set as Static Front Page', 'twentytwelve' ),
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget'  => '</aside>',
      'before_title'  => '<h3 class="widget-title">',
      'after_title'   => '</h3>',
    )
  );

  register_sidebar(
    array(
      'name'          => __( 'Second Front Page Widget Area', 'twentytwelve' ),
      'id'            => 'sidebar-3',
      'description'   => __( 'Appears when using the optional Front Page template with a page set as Static Front Page', 'twentytwelve' ),
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget'  => '</aside>',
      'before_title'  => '<h3 class="widget-title">',
      'after_title'   => '</h3>',
    )
  );
}
add_action( 'widgets_init', 'twentytwelve_widgets_init' );

if ( ! function_exists( 'twentytwelve_content_nav' ) ) :
  /**
   * Displays navigation to next/previous pages when applicable.
   *
   * @since Twenty Twelve 1.0
   */
  function twentytwelve_content_nav( $html_id ) {
    global $wp_query;

    if ( $wp_query->max_num_pages > 1 ) : ?>
      <nav id="<?php echo esc_attr( $html_id ); ?>" class="navigation" role="navigation">
        <h3 class="assistive-text"><?php _e( 'Post navigation', 'twentytwelve' ); ?></h3>
        <div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'twentytwelve' ) ); ?></div>
        <div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'twentytwelve' ) ); ?></div>
      </nav><!-- .navigation -->
      <?php
  endif;
  }
endif;

if ( ! function_exists( 'twentytwelve_comment' ) ) :
  /**
   * Template for comments and pingbacks.
   *
   * To override this walker in a child theme without modifying the comments template
   * simply create your own twentytwelve_comment(), and that function will be used instead.
   *
   * Used as a callback by wp_list_comments() for displaying the comments.
   *
   * @since Twenty Twelve 1.0
   */
  function twentytwelve_comment( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    switch ( $comment->comment_type ) :
      case 'pingback':
      case 'trackback':
        // Display trackbacks differently than normal comments.
        ?>
    <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
    <p><?php _e( 'Pingback:', 'twentytwelve' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'twentytwelve' ), '<span class="edit-link">', '</span>' ); ?></p>
        <?php
        break;
      default:
        // Proceed with normal comments.
        global $post;
        ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
    <article id="comment-<?php comment_ID(); ?>" class="comment">
      <header class="comment-meta comment-author vcard">
        <?php
          echo get_avatar( $comment, 44 );
          printf(
            '<cite><b class="fn">%1$s</b> %2$s</cite>',
            get_comment_author_link(),
            // If current post author is also comment author, make it known visually.
            ( $comment->user_id === $post->post_author ) ? '<span>' . __( 'Post author', 'twentytwelve' ) . '</span>' : ''
          );
          printf(
            '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
            esc_url( get_comment_link( $comment->comment_ID ) ),
            get_comment_time( 'c' ),
            /* translators: 1: date, 2: time */
            sprintf( __( '%1$s at %2$s', 'twentytwelve' ), get_comment_date(), get_comment_time() )
          );
        ?>
        </header><!-- .comment-meta -->

        <?php if ( '0' == $comment->comment_approved ) : ?>
        <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'twentytwelve' ); ?></p>
      <?php endif; ?>

        <section class="comment-content comment">
        <?php comment_text(); ?>
        <?php edit_comment_link( __( 'Edit', 'twentytwelve' ), '<p class="edit-link">', '</p>' ); ?>
        </section><!-- .comment-content -->

        <div class="reply">
        <?php
        comment_reply_link(
          array_merge(
            $args,
            array(
              'reply_text' => __( 'Reply', 'twentytwelve' ),
              'after'      => ' <span>&darr;</span>',
              'depth'      => $depth,
              'max_depth'  => $args['max_depth'],
            )
          )
        );
        ?>
        </div><!-- .reply -->
      </article><!-- #comment-## -->
        <?php
        break;
    endswitch; // end comment_type check
  }
endif;

if ( ! function_exists( 'twentytwelve_entry_meta' ) ) :
  /**
   * Set up post entry meta.
   *
   * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
   *
   * Create your own twentytwelve_entry_meta() to override in a child theme.
   *
   * @since Twenty Twelve 1.0
   */
  function twentytwelve_entry_meta() {
    // Translators: used between list items, there is a space after the comma.
    $categories_list = get_the_category_list( __( ', ', 'twentytwelve' ) );

    // Translators: used between list items, there is a space after the comma.
    $tag_list = get_the_tag_list( '', __( ', ', 'twentytwelve' ) );

    $date = sprintf(
      '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>',
      esc_url( get_permalink() ),
      esc_attr( get_the_time() ),
      esc_attr( get_the_date( 'c' ) ),
      esc_html( get_the_date() )
    );

    $author = sprintf(
      '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
      esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
      esc_attr( sprintf( __( 'View all posts by %s', 'twentytwelve' ), get_the_author() ) ),
      get_the_author()
    );

    // Translators: 1 is category, 2 is tag, 3 is the date and 4 is the author's name.
    if ( $tag_list ) {
      $utility_text = __( 'This entry was posted in %1$s and tagged %2$s on %3$s<span class="by-author"> by %4$s</span>.', 'twentytwelve' );
    } elseif ( $categories_list ) {
      $utility_text = __( 'This entry was posted in %1$s on %3$s<span class="by-author"> by %4$s</span>.', 'twentytwelve' );
    } else {
      $utility_text = __( 'This entry was posted on %3$s<span class="by-author"> by %4$s</span>.', 'twentytwelve' );
    }

    printf(
      $utility_text,
      $categories_list,
      $tag_list,
      $date,
      $author
    );
  }
endif;

/**
 * Extend the default WordPress body classes.
 *
 * Extends the default WordPress body class to denote:
 * 1. Using a full-width layout, when no active widgets in the sidebar
 *    or full-width template.
 * 2. Front Page template: thumbnail in use and number of sidebars for
 *    widget areas.
 * 3. White or empty background color to change the layout and spacing.
 * 4. Custom fonts enabled.
 * 5. Single or multiple authors.
 *
 * @since Twenty Twelve 1.0
 *
 * @param array $classes Existing class values.
 * @return array Filtered class values.
 */
function twentytwelve_body_class( $classes ) {
  $background_color = get_background_color();
  $background_image = get_background_image();

  if ( ! is_active_sidebar( 'sidebar-1' ) || is_page_template( 'page-templates/full-width.php' ) ) {
    $classes[] = 'full-width';
  }

  if ( is_page_template( 'page-templates/front-page.php' ) ) {
    $classes[] = 'template-front-page';
    if ( has_post_thumbnail() ) {
      $classes[] = 'has-post-thumbnail';
    }
    if ( is_active_sidebar( 'sidebar-2' ) && is_active_sidebar( 'sidebar-3' ) ) {
      $classes[] = 'two-sidebars';
    }
  }

  if ( empty( $background_image ) ) {
    if ( empty( $background_color ) ) {
      $classes[] = 'custom-background-empty';
    } elseif ( in_array( $background_color, array( 'fff', 'ffffff' ) ) ) {
      $classes[] = 'custom-background-white';
    }
  }

  // Enable custom font class only if the font CSS is queued to load.
  if ( wp_style_is( 'twentytwelve-fonts', 'queue' ) ) {
    $classes[] = 'custom-font-enabled';
  }

  if ( ! is_multi_author() ) {
    $classes[] = 'single-author';
  }

  return $classes;
}
add_filter( 'body_class', 'twentytwelve_body_class' );

/**
 * Adjust content width in certain contexts.
 *
 * Adjusts content_width value for full-width and single image attachment
 * templates, and when there are no active widgets in the sidebar.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_content_width() {
  if ( is_page_template( 'page-templates/full-width.php' ) || is_attachment() || ! is_active_sidebar( 'sidebar-1' ) ) {
    global $content_width;
    $content_width = 960;
  }
}
add_action( 'template_redirect', 'twentytwelve_content_width' );

/**
 * Register postMessage support.
 *
 * Add postMessage support for site title and description for the Customizer.
 *
 * @since Twenty Twelve 1.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function twentytwelve_customize_register( $wp_customize ) {
  $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
  $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
  $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

  if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial(
      'blogname',
      array(
        'selector'            => '.site-title > a',
        'container_inclusive' => false,
        'render_callback'     => 'twentytwelve_customize_partial_blogname',
      )
    );
    $wp_customize->selective_refresh->add_partial(
      'blogdescription',
      array(
        'selector'            => '.site-description',
        'container_inclusive' => false,
        'render_callback'     => 'twentytwelve_customize_partial_blogdescription',
      )
    );
  }
}
add_action( 'customize_register', 'twentytwelve_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @since Twenty Twelve 2.0
 * @see twentytwelve_customize_register()
 *
 * @return void
 */
function twentytwelve_customize_partial_blogname() {
  bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @since Twenty Twelve 2.0
 * @see twentytwelve_customize_register()
 *
 * @return void
 */
function twentytwelve_customize_partial_blogdescription() {
  bloginfo( 'description' );
}

/**
 * Enqueue Javascript postMessage handlers for the Customizer.
 *
 * Binds JS handlers to make the Customizer preview reload changes asynchronously.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_customize_preview_js() {
  wp_enqueue_script( 'twentytwelve-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), '20141120', true );
}
add_action( 'customize_preview_init', 'twentytwelve_customize_preview_js' );


/**
 * Modifies tag cloud widget arguments to display all tags in the same font size
 * and use list format for better accessibility.
 *
 * @since Twenty Twelve 2.4
 *
 * @param array $args Arguments for tag cloud widget.
 * @return array The filtered arguments for tag cloud widget.
 */
function twentytwelve_widget_tag_cloud_args( $args ) {
  $args['largest']  = 22;
  $args['smallest'] = 8;
  $args['unit']     = 'pt';
  $args['format']   = 'list';

  return $args;
}
add_filter( 'widget_tag_cloud_args', 'twentytwelve_widget_tag_cloud_args' );

/**
 * Register sidebars.
 */
require_once( get_stylesheet_directory() . '/theme-functions/widget-areas.php' );

/**
 * Theme Social Media Settings.
 */
require_once( get_stylesheet_directory() . '/theme-functions/theme-social.php' );

/**
 * Theme Shortcode.
 */
require_once( get_stylesheet_directory() . '/theme-functions/theme-shortcode.php' );

/**
 * Theme Widget
 */
 require_once(get_stylesheet_directory() . '/theme-functions/custom_widget.php');

/**
 * Shortcode Button.
 */
 require_once( get_stylesheet_directory() . '/tinymce_button/shortcode_button.php' );

 /**
 * Theme Shortcode.
 */
  require_once( get_stylesheet_directory() . '/tinymce_button/shortcode-ajax.php' );

  /**
  * OII Menu Walker
  **/
 require_once( get_stylesheet_directory() . '/classes/oii-walker.php' );

  /**
  * Page Edit Modal Parent Attribute
  **/
  require_once( get_stylesheet_directory() . '/modules/modal-parent/modal_parent.php' );

 /**
 * Shortcodes Blocks
 **/
 $_vsn = (int)explode('.',get_bloginfo('version'))[0];
 if($_vsn > 4) require_once( get_stylesheet_directory() . '/modules/shortcodesblockv2/accordion_v2/oese-accordion-block.php' );
 if($_vsn > 4) require_once( get_stylesheet_directory() . '/modules/shortcodesblockv2/featured_item/oese-featured-item-block.php' );
 if($_vsn > 4) require_once( get_stylesheet_directory() . '/modules/shortcodesblockv2/disruptive_content/oese-disruptive-content-block.php' );
 if($_vsn > 4) require_once( get_stylesheet_directory() . '/modules/shortcodesblockv2/featured_video/oese-featured-video-block.php' );
 if($_vsn > 4) require_once( get_stylesheet_directory() . '/modules/shortcodesblockv2/pull_quote/oese-pull-quote-block.php' );
 if($_vsn > 4) require_once( get_stylesheet_directory() . '/modules/shortcodesblockv2/recommended_resources/oese-recommended-resources-block.php' );
 if($_vsn > 4) require_once( get_stylesheet_directory() . '/modules/shortcodesblockv2/featured_content_box/oese-featured-content-box-block.php' );
 if($_vsn > 4) require_once( get_stylesheet_directory() . '/modules/shortcodesblockv2/callout_box/oese-callout-box-block.php' );
 if($_vsn > 4) require_once( get_stylesheet_directory() . '/modules/shortcodesblockv2/audience_link/oese-audience-link-block.php' );
 if($_vsn > 4) require_once( get_stylesheet_directory() . '/modules/shortcodesblockv2/subpages/oese-subpages-block.php' );
 if($_vsn > 4) require_once( get_stylesheet_directory() . '/modules/shortcodesblockv2/featured_card/oese-featured-card-block.php' );
 if($_vsn > 4) require_once( get_stylesheet_directory() . '/modules/shortcodesblockv2/disclaimer/oese-disclaimer-block.php' );
 if($_vsn > 4) require_once( get_stylesheet_directory() . '/modules/shortcodesblockv2/tabs/oese-tabs.php' );
 if($_vsn > 4) require_once( get_stylesheet_directory() . '/modules/shortcodesblock/shortcodesblock.php' );
 function theme_back_enqueue_script()
{
    wp_enqueue_script( 'jquery-ui-core' );
	wp_enqueue_script( 'jquery-ui-widgets' );
	wp_enqueue_script( 'jquery-ui-tabs' );
    wp_enqueue_script( 'theme-back-script', get_stylesheet_directory_uri() . '/js/back-script.js', array());
    wp_enqueue_script('csv-media-script', get_stylesheet_directory_uri() . '/js/csv-media-import-script.js' );
    wp_enqueue_style( 'theme-back-style',get_stylesheet_directory_uri() . '/css/back-style.css' );
    wp_enqueue_style( 'tinymce_button_backend',get_stylesheet_directory_uri() . '/tinymce_button/shortcode_button.css' );
    wp_localize_script( 'theme-back-script', 'oet_ajax_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
    wp_enqueue_style( 'theme-font-style',get_stylesheet_directory_uri() . '/css/fontawesome/css/all.min.css' );
    if(get_admin_page_title() == 'Edit Page' ||
       get_admin_page_title() == 'Edit Post' ||
       get_admin_page_title() == 'Add New Page' ||
       get_admin_page_title() == 'Add New Post' ||
       get_admin_page_title() == 'Edit Reusable Block'){
    //if(get_admin_page_title() != 'Media Library' && get_admin_page_title() != 'Manage Themes'){;
      wp_enqueue_style( 'theme-bootstrap-style',get_stylesheet_directory_uri() . '/css/bootstrap.min.css' );
      wp_enqueue_script('bootstrap-script', get_stylesheet_directory_uri() . '/js/bootstrap.js' );
    }

    wp_enqueue_style('csv-media-styles', get_stylesheet_directory_uri() . '/css/csv-media-import-style.css' );
    wp_enqueue_style( 'shortcode-style-backend',get_stylesheet_directory_uri() . '/tinymce_button/shortcode-style.css' );
    wp_enqueue_script('shortcode_script', get_stylesheet_directory_uri() . '/tinymce_button/shortcode_script.js' );
    if (is_page_template('page-templates/nalrc-template.php') || 'resource'==get_post_type()){
      wp_enqueue_style( 'theme-bootstrap-style',get_stylesheet_directory_uri() . '/css/bootstrap.min.css' );
      wp_enqueue_script('bootstrap-script', get_stylesheet_directory_uri() . '/js/bootstrap.js' );
    }
}
add_action( 'admin_enqueue_scripts', 'theme_back_enqueue_script' );

function theme_front_enqueue_script()
{
  global $post;
  wp_enqueue_style( 'theme-front-style',get_stylesheet_directory_uri() . '/css/front-style.css');
  wp_enqueue_style( 'theme-bootstrap-style',get_stylesheet_directory_uri() . '/css/bootstrap.min.css' );
  wp_enqueue_style( 'theme-font-style',get_stylesheet_directory_uri() . '/css/fontawesome/css/all.min.css' );

  wp_enqueue_style( 'theme-main-style',get_stylesheet_directory_uri() . '/css/mainstyle.css' );
  wp_enqueue_style( 'theme-wpdt-style',get_stylesheet_directory_uri() . '/css/wpdt.css', array());
  wp_enqueue_script('jquery');
  if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'wpdatatable')){
    wp_enqueue_script('ie-detection-script', get_stylesheet_directory_uri().'/js/ie-detect.js');
  }
  wp_enqueue_script('popper-script', get_stylesheet_directory_uri() . '/js/popper.min.js' );
  wp_enqueue_script('bootstrap-script', get_stylesheet_directory_uri() . '/js/bootstrap.js' );
  wp_enqueue_script('theme-front-script', get_stylesheet_directory_uri() . '/js/front-script.js' );
  wp_enqueue_script('theme-back-script', get_stylesheet_directory_uri() . '/js/modernizr-custom.js' );

  // Load NALRC styles
  if (is_page_template('page-templates/nalrc-template.php') || 'resource'==get_post_type()){
    wp_enqueue_style( 'theme-nalrc-style',get_stylesheet_directory_uri() . '/css/nalrc.css' );
    wp_register_script( 'theme-nalrc-script',get_stylesheet_directory_uri() . '/js/nalrc.js');
    wp_localize_script( 'theme-nalrc-script', 'nalrc', array( 'home_url' => get_site_url()) );
    wp_enqueue_script( 'theme-nalrc-script');
    wp_enqueue_style('dashicons');
  }
}
add_action( 'wp_enqueue_scripts', 'theme_front_enqueue_script');

function the_content_filter($content) {
    $block = join("|",array("home_left_column", "home_right_column"));
    $rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);
    $rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$rep);
  return $rep;
}
add_filter("the_content", "the_content_filter");

function wpse_wpautop_nobr( $content )
{
  return wpautop( $content, false );
}

function my_remove_version_info() {
     return '';
}
add_filter('the_generator', 'my_remove_version_info');

// remove wp version param from any enqueued scripts
function vc_remove_wp_ver_css_js( $src ) {
    if ( strpos( $src, 'ver=' ) )
        $src = esc_url( remove_query_arg( 'ver', $src ) );
    return $src;
}
add_filter( 'style_loader_src', 'vc_remove_wp_ver_css_js', 9999 );
add_filter( 'script_loader_src', 'vc_remove_wp_ver_css_js', 9999 );

// Fed Govt analytics script
function federated_analytics_tracking_code(){
    echo '<script type="text/javascript" id="_fed_an_ua_tag" src="https://dap.digitalgov.gov/Universal-Federated-Analytics-Min.js?agency=ED"></script>';
}
add_action('wp_head', 'federated_analytics_tracking_code');

/* Frontend loaded Google fonts*/
function load_frontend_google_fonts() {
    ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,400;0,700;1,400;1,700&family=Raleway:ital,wght@0,400;0,600;0,700;1,400;1,600;1,700&family=Roboto:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <?php
}
add_action( 'wp_head', 'load_frontend_google_fonts' );

/* Admin loaded Google fonts*/
function load_admin_google_fonts() {
    ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,400;0,700;1,400;1,700&family=Raleway:ital,wght@0,400;0,600;0,700;1,400;1,600;1,700&family=Roboto:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <?php
}
add_action( 'admin_head', 'load_admin_google_fonts' );


/**
 * Title tag filter - to include parent titles
 */
// function oii_title_filter( $title, $sep, $seplocation ) {
//     global $post;
//     // get special index page type (if any)
//     if( is_category() ) $type = 'News Category';
//     elseif( is_tag() ) $type = 'Tag';
//     elseif( is_author() ) $type . 'Author';
//     elseif( is_date() || is_archive() ) $type = 'Archives';
//     else $type = false;

//     // get the page number
//     if( get_query_var( 'paged' ) )
//         $page_num = 'Page '.get_query_var( 'paged' ); // on index
//     elseif( get_query_var( 'page' ) )
//         $page_num = get_query_var( 'page' ); // on single
//     else $page_num = false;

//     // strip title separator
//     $title = trim( str_replace( $sep, '', $title ) );

//     if(intval($post->post_parent)>0)
//      $title = get_the_title($post->post_parent) . ' '.$sep.' '. $title;

//     // determine order based on seplocation
//     $parts = array( get_bloginfo( 'name' ), $type, $title, $page_num );
//     if( $seplocation == 'left' )
//         $parts = array_reverse( $parts );

//     // strip blanks, implode, and return title tag
//     $parts = array_filter( $parts );
//     return implode( ' ' . $sep . ' ', $parts );
// }
// add_filter( 'wp_title', 'oii_title_filter', 10, 3 );

// remove the default twentytwelve_title filter
add_action( 'after_setup_theme', 'oii_turnoff_twentytwelve_title' );
function oii_turnoff_twentytwelve_title() {
        remove_filter( 'wp_title', 'twentytwelve_wp_title', 10, 2 );
}

// Google Analytics script
// function google_analytics_with_pagetitle(){
//     $ga_id = 'UA-64242956-1';
//  $sep = '|';

//     $pagetitle = trim( str_replace( get_bloginfo('name'), '', wp_title('|', false) ), $sep.' ');

//  // is the current page a tag archive page?
//  if ( is_home() || is_front_page() ) {
//    $pagetitle = 'Home';

//  } elseif (function_exists('is_tag') && is_tag()) {
//    $pagetitle = 'Tag Archive - '.$tag;

//  // or, is the page a search page?
//  } elseif (is_search()) {
//    $pagetitle = 'Search for &quot;'.get_search_query().'&quot;';

//  // or, is the page an error page?
//  } elseif (is_404()) {
//    $pagetitle = '404 Error - Page Not Found';
//  }

//     echo "<script>(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','//www.google-analytics.com/analytics.js','ga'); ";
//     echo "ga('create', '" . $ga_id . "', 'auto'); ";
//  echo "ga('send', 'pageview', {'title': '". $pagetitle ."' }); </script>";

// }
// add_action('wp_head', 'google_analytics_with_pagetitle');

/**
 * Shorten any title that is more than X characters long
 *
 * @param  string $link_text  The title of the post
 * @param  int $id    The ID of the post
 *
 * @return  string    The title, shortened if too long
 */
add_filter('wpseo_breadcrumb_single_link_info', 'truncate_breadcrumbs', 10, 2);
function truncate_breadcrumbs($link, $id) {

  $crumb_length = strlen( $link['text'] );

  // Allowed breadcrumb size.
  $crumb_size = 24;

  // Shorten the title.
  $truncated = substr( $link['text'], 0, $crumb_size );

  // Add an ellipsis if the title has been truncated.
  if ( $crumb_length > $crumb_size ) {
    $truncated .= '...';
  }

  $link['text'] = $truncated;

  return $link;

}

/**
 * Related Posts Widget.
 */
require_once( get_stylesheet_directory() . '/widgets/related_posts_widget.php' );
add_action( 'widgets_init' , 'register_oii_widget' );

function register_oii_widget(){
    register_widget( 'Related_Posts_Widget' );
}

/**
 * News Categories Widget
 **/
require_once( get_stylesheet_directory() . '/widgets/news_categories_widget.php' );
add_action( 'widgets_init' , 'register_news_categories_widget' );
function register_news_categories_widget(){
    register_widget( 'News_Categories_Widget' );
}

/* minor style changes to News "Continue Reading" links */
add_filter( 'the_content_more_link', 'modify_read_more_link' );
function modify_read_more_link() {
  return ' <a class="more-link" href="' . get_permalink() . '">Read More</a>';
}

/**
 * Initialize Categories and Tags for Pages
 **/
add_action( 'init', 'taxonomies_for_pages' );
if ( ! is_admin() ) {
    add_action( 'pre_get_posts',  'category_archives' );
    add_action( 'pre_get_posts', 'tags_archives' );
} //

/**
* Registers the taxonomy terms for the post type
*
*/
function taxonomies_for_pages() {
    register_taxonomy_for_object_type( 'post_tag', 'page' );
    register_taxonomy_for_object_type( 'category', 'page' );
} // taxonomies_for_pages

/**
  * Includes the tags in archive pages
  *
  * Modifies the query object to include pages
  * as well as posts in the items to be returned
  * on archive pages
  *
  */
 function tags_archives( $wp_query ) {
    if ( $wp_query->get( 'tag' ) )
        $wp_query->set( 'post_type', 'any' );

 } // tags_archives

 /**
  * Includes the categories in archive pages
  *
  * Modifies the query object to include pages
  * as well as posts in the items to be returned
  * on archive pages
  *
  */
 function category_archives( $wp_query ) {
    if ( $wp_query->get( 'category_name' ) || $wp_query->get( 'cat' ) )
        $wp_query->set( 'post_type', 'any' );

 } // category_archives

 function related_posts_where( $where ) {
    return $where." AND post_type='post'";
}

// altered wp_list_categories
function wp_list_categories_for_posts( $args = '' ) {
    $defaults = array(
      'show_option_all' => '', 'show_option_none' => __('No categories'),
      'orderby' => 'name', 'order' => 'ASC',
      'style' => 'list',
      'show_count' => 0, 'hide_empty' => 1,
      'use_desc_for_title' => 1, 'child_of' => 0,
      'feed' => '', 'feed_type' => '',
      'feed_image' => '', 'exclude' => '',
      'exclude_tree' => '', 'current_category' => 0,
      'hierarchical' => true, 'title_li' => __( 'Categories' ),
      'echo' => 1, 'depth' => 0,
      'taxonomy' => 'category'
    );

    $r = wp_parse_args( $args, $defaults );

    if ( !isset( $r['pad_counts'] ) && $r['show_count'] && $r['hierarchical'] )
  $r['pad_counts'] = true;

    if ( true == $r['hierarchical'] ) {
  $r['exclude_tree'] = $r['exclude'];
  $r['exclude'] = '';
    }

    if ( ! isset( $r['class'] ) )
  $r['class'] = ( 'category' == $r['taxonomy'] ) ? 'categories' : $r['taxonomy'];

    if ( ! taxonomy_exists( $r['taxonomy'] ) ) {
  return false;
    }

    $show_option_all = $r['show_option_all'];
    $show_option_none = $r['show_option_none'];

    $categories = get_categories( $r );
    foreach ($categories as $key => $category){
       add_filter( 'posts_where' , 'related_posts_where' );
  $rPosts = new WP_Query(array(
    'post_type'             => array('post'),
    'posts_per_page'  => -1,
    'is_single'             => true,
    'no_found_rows'         => true,
    'post_status'           => array('publish'),
    'ignore_sticky_posts'   => true,
    'cat'                   => $category->cat_ID
  ));

  // If no posts found, ...
  if ($rPosts->post_count==0) {
      unset($categories[$key]);
  } else {
      $categories[$key]->count = $rPosts->post_count;
  }
    }

    $output = '';
    if ( $r['title_li'] && 'list' == $r['style'] ) {
      $output = '<li class="' . esc_attr( $r['class'] ) . '">' . $r['title_li'] . '<ul>';
    }
    if ( empty( $categories ) ) {
      if ( ! empty( $show_option_none ) ) {
        if ( 'list' == $r['style'] ) {
          $output .= '<li class="cat-item-none">' . $show_option_none . '</li>';
        } else {
          $output .= $show_option_none;
        }
      }
    } else {
      if ( ! empty( $show_option_all ) ) {
        $posts_page = ( 'page' == get_option( 'show_on_front' ) && get_option( 'page_for_posts' ) ) ? get_permalink( get_option( 'page_for_posts' ) ) : home_url( '/' );
        $posts_page = esc_url( $posts_page );
        if ( 'list' == $r['style'] ) {
          $output .= "<li class='cat-item-all'><a href='$posts_page'>$show_option_all</a></li>";
        } else {
          $output .= "<a href='$posts_page'>$show_option_all</a>";
        }
      }

      if ( empty( $r['current_category'] ) && ( is_category() || is_tax() || is_tag() ) ) {
        $current_term_object = get_queried_object();
        if ( $current_term_object && $r['taxonomy'] === $current_term_object->taxonomy ) {
          $r['current_category'] = get_queried_object_id();
        }
      }

      if ( $r['hierarchical'] ) {
        $depth = $r['depth'];
      } else {
        $depth = -1; // Flat.
      }
      $output .= walk_category_tree( $categories, $depth, $r );
    }

    if ( $r['title_li'] && 'list' == $r['style'] )
      $output .= '</ul></li>';

    /**
     * Filter the HTML output of a taxonomy list.
     *
     * @since 2.1.0
     *
     * @param string $output HTML output.
     * @param array  $args   An array of taxonomy-listing arguments.
     */
    $html = apply_filters( 'wp_list_categories', $output, $args );
    wp_reset_postdata();
    if ( $r['echo'] ) {
      echo $html;
    } else {
      return $html;
    }
}

 /**
 * Register the footer Menu - removed in base twentytwelve theme
 */
register_nav_menu( 'footer', __( 'Footer Menu', 'twentytwelve' ) );

register_nav_menu( 'sub-footer', __( 'Sub Footer', WP_OESE_THEME_SLUG ) );
/**
* Getting Populars post from Pages OESE Theme
*/
function getSidebarLinks($showHeader=true){

    if( have_rows('sidebar_links') ):
        $output = "<div class='secondary-navigation-menu sidebar-links'>";
        $header_style = "";
        $body_style = "";
        $additional_body_style = "";
        $header_text_style = "";
        $sidebar_header_color = get_field('sidebar_title_box_color');
        $sidebar_body_color = get_field('sidebar_box_body_color');
        $sidebar_header_text_color = get_field('sidebar_box_title_color');

    if (!empty($sidebar_header_color))
        $header_style = " style='background-color:".$sidebar_header_color."'";

    $count = count(get_field("sidebar_links"));
    if ($count==1){
        $additional_body_style = "columns:1;-webkit-columns:1;-moz-columns:1;";
    }

    if (!empty($sidebar_body_color))
        $body_style = " style='background-color:".$sidebar_body_color.";".$additional_body_style."'";
    elseif (!empty($additional_body_style)){
        $body_style = " style='".$additional_body_style."'";
    }


    if (!empty($sidebar_header_text_color))
        $header_text_style = " style='color:".$sidebar_header_text_color."'";

    if ($showHeader==true)
        $output .= "<div class='secondary-navigation-menu-header'".$header_style."><h2".$header_text_style.">". get_field('sidebar_box_title')."</h2></div>";

        // check if the repeater field has rows of data
        $output.=  "<ul class='secondary-navigation-menu-list'".$body_style.">";

        // loop through the rows of data
        while ( have_rows('sidebar_links') ) : the_row();
            $resourceLabel =  get_sub_field('resource_label');
            $resourceLink =  (get_sub_field('resource_link'))? get_sub_field('resource_link'): "";
            $externaLink =  get_sub_field('external_link');
            $target = ($externaLink ? "_blank" : "_self");
            if(trim($resourceLink)!==""){
              $output.= "<li><a target='". $target."' href='".$resourceLink."'>".$resourceLabel."</a></li>";
            }else{
              $output.= "<li class='unlinked'><span>".$resourceLabel."</span></li>";
            }
        endwhile;
        $output.=  "</ul>";
        $output.="</div>";
        echo $output;
    endif;
}

/**
*Enabling the Category and Tags for the media attachment
*
**/
function addingCategoryToAttachment() {
    register_taxonomy_for_object_type( 'category', 'attachment' );
}
add_action( 'init' , 'addingCategoryToAttachment' );

function addingTagsToAttachment() {
    register_taxonomy_for_object_type( 'post_tag', 'attachment' );
}
add_action( 'init' , 'addingTagsToAttachment' );

/*
* Category Filter for Media List Page
*/

//add_action('pre_get_posts', 'mediaFilterByCategory');

function mediaFilterByCategory( $q ) {
    if(is_admin()){
        global $current_user, $pagenow;

        if( !is_a( $current_user, 'WP_User') )
            return;

        $cat = filter_input(INPUT_GET, 'category_name', FILTER_SANITIZE_STRING );

        if ( ! $q->is_main_query() || ! is_admin() || (int)$cat <= 0 || !in_array( $pagenow, array( 'upload.php', 'admin-ajax.php' ) ))
            return;

        $posts = get_posts( 'nopaging=1&category=' . $cat );
        $pids = ( ! empty( $posts ) ) ? wp_list_pluck($posts, 'ID') : false;

        if ( ! empty($pids) ) {
            $pidstxt = implode($pids, ',');
            global $wpdb;
            $mids = $wpdb->get_col("SELECT ID FROM $wpdb->posts WHERE post_parent IN ($pidstxt)");
            if ( ! empty($mids) ) {
                $q->set( 'post__in', $mids );
            } else {
                $q->set( 'p', -1 );
            }
        }
    }
}

//add_action( 'restrict_manage_posts', 'mediaCategoryDropdown' );

function mediaCategoryDropdown() {
    $scr = get_current_screen();
    if ( $scr->base !== 'upload' ) return;
    $cat = filter_input(INPUT_GET, 'category_name', FILTER_SANITIZE_STRING );
    $selected = (int)$cat > 0 ? $cat : '-1';
    $args = array(
        'show_option_none'   => 'All Post Categories',
        'name'               => 'category_name',
        'selected'           => $selected,
        'value_field'       => 'slug'
    );
    wp_dropdown_categories( $args );
}

function oeseBreadcrumb() {
  if(!is_front_page()){
    $html = ' <div class="col-md-12"><a class="breadcrumbs-link" href="'.home_url().'" rel="nofollow">OESE</a>';

    if (is_category() || is_single()) {
        $html .=  "&nbsp;&nbsp;&#47;&nbsp;&nbsp;";
        the_category(' &bull; ');
        if (is_single()) {
            $html .= "&nbsp;&nbsp;&#47;&nbsp;&nbsp;";
            $html .= "<a href='#' class='breadcrumbs-link active'>".get_the_title()."</a>";
        }
    } elseif (is_page()) {
        $html .= " &nbsp;&nbsp;&#47;&nbsp;&nbsp;";
        $html .=  "<a href='#' class='breadcrumbs-link active'>".get_the_title()."</a>";

    } elseif (is_search()) {
        $html .=  "&nbsp;&nbsp;&#47;&nbsp;&nbsp;Search Results for... ";
        $html .=  '"<em>';
        $html .=  the_search_query();
        $html .=  '</em>"';
    }
    $html .="</div>";
    echo $html;

  }
}

function contactInformationBlock($showHeader=true){
  global $post;

  $contactTitle = get_field("ci_title");
  $contactAddress = get_field("ci_address");
  $contactPhone = get_field("ci_phone");
  $contactFax = get_field("ci_fax");
  $contactEmailCheck = get_field("ci_email");
  $contactEmailOption = get_field("ci_email");
  $contactEmailAddress = get_field("ci_email_address");
  $contact_page = get_option('wp_oese_theme_contact_page');
  $contact_default_email = get_option('wp_oese_theme_default_email');

  // email link option - contact page or email address
  $contactEmailLink = "";
  if($contactEmailOption != 'disabled'){
    if( ($contactEmailOption == 'email') && ($contactEmailAddress) ){
      $contactEmailLink = 'mailto:'.$contactEmailAddress.'?subject=OESE Website Contact: '.sanitize_text_field($post->post_title);
    } elseif ($contactEmailOption == 'default_email' && $contact_default_email){
      $contactEmailLink = 'mailto:'.$contact_default_email.'?subject=OESE Website Contact: '.sanitize_text_field($post->post_title);
    } elseif ($contactEmailOption == 'contact_form'){
      if ($contact_page){
        $contactEmailLink = get_the_permalink($contact_page).'?contact_reference='.$post->ID;
      } else
        $contactEmailLink = '';
    }
  }

  $output = "";
  if(!empty($contactAddress) || (!empty($contactPhone)) || (!empty($contactFax)) || (!empty($contactEmailLink))){
      $output = '<div class="secondary-navigation-menu contact-box">';

      if ($showHeader==true){
          $output .=   '<div class="secondary-navigation-menu-header">
                            <h2>'.$contactTitle.'</h2>
                        </div>';
      }
      $output .=  '<ul class="secondary-navigation-menu-list">';

     if(!empty($contactAddress)){
       $output.=  '<li>'.$contactAddress.'</li>';
     }

     if(!empty($contactPhone)){
      $output.=  '<li>
                    <div class="sub-nav-icons">
                        <span>
                          <i class="fas fa-phone"></i>
                        </span>
                        <p>'.$contactPhone.'</p>
                    </div>
                  </li>';
     }
    if(!empty($contactFax)){
      $output.= '<li>
                    <div class="sub-nav-icons">
                        <span>
                          <i class="fas fa-fax"></i>
                        </span>
                        <p>'.$contactFax.' FAX</p>
                     </div>
                </li>';
    }

    if(!empty($contactEmailLink)){
      if ($contactEmailOption=="email")
        $output .= '<li>
                  <div class="sub-nav-icons">
                    <span><i class="fas fa-envelope"></i></span>
                    <p><a href="'.$contactEmailLink.'" onclick="oese_trackEvent(\'Contact\',\'click\',\''.$post->post_title.'\',\'Email\')">E-mail</a></p>
                  </div>
                </li>';
      elseif ($contactEmailOption=="contact_form")
        $output .= '<li>
                  <div class="sub-nav-icons">
                    <span><i class="far fa-address-card"></i></span>
                    <p><a href="'.$contactEmailLink.'" onclick="oese_trackEvent(\'Contact\',\'click\',\''.$post->post_title.'\',\'Contact Form\');">Contact Us</a></p>
                  </div>
                </li>';
      elseif ($contactEmailOption=="default_email" && $contact_default_email)
        $output .= '<li>
                  <div class="sub-nav-icons">
                    <span><i class="fas fa-envelope"></i></span>
                    <p><a href="'.$contactEmailLink.'" onclick="oese_trackEvent(\'Contact\',\'click\',\''.$post->post_title.'\',\'Email\')">E-mail</a></p>
                  </div>
                </li>';
    }

    $output .= '</ul></div>';
  }
  return $output;

}

function getTileLinks(){
   if( have_rows('tile_links') ):
      $output = "<ul class='row tile-links-wrapper custom-common-padding gray-background-color mr-0 ml-0'>";
         while ( have_rows('tile_links') ) : the_row();
              $tileLinkLabel =  get_sub_field('tile_link_title');
              $tileLinkUrl =  get_sub_field('tile_link_url');
              $externaLink =  get_sub_field('external_link');
              $tileLinkWidth =  get_sub_field('width');
               if($tileLinkWidth == "third"){
                $colSize = "col-md-4 office-custom-padding office-grid-section-custom-margin half-tile-link";
                $outerDivClass = "office-grid-section";
                $innerDivClass = "office-grid-list-details text-center";
              } elseif($tileLinkWidth == "half"){
                $colSize = "col-md-6 office-custom-padding office-grid-section-custom-margin half-tile-link";
                $outerDivClass = "office-grid-section";
                $innerDivClass = "office-grid-list-details text-center";
              }
              else{
                $colSize = "col-md-12 col-md-12 payments-custom-padding full-tile-link";
                $outerDivClass = "payments-overlay-section";
                $innerDivClass = "payments-details-list text-center";
              }
              $target = ($externaLink ? "_blank" : "_self");
              $output.= '<li class="'.$colSize.'">
                            <div class="'.$outerDivClass.'">
                              <a target="'.$target.'" href="'.$tileLinkUrl.'" class="tile-link">
                                <div class="'.$innerDivClass.'">
                                  <p>'.$tileLinkLabel.'</p>
                                </div>
                                </a>
                            </div>
                          </li>';
            endwhile;
         $output.="</ul>";
         echo $output;
    endif;
}

function oeseListChildPages() {

  global $post;
  if ( is_page() && $post->post_parent )

      $childpages = wp_list_pages( 'sort_column=menu_order&title_li=&child_of=' . $post->post_parent . '&echo=0' );
  else
      $childpages = wp_list_pages( 'sort_column=menu_order&title_li=&child_of=' . $post->ID . '&echo=0' );

  if ( $childpages ) {
    $string = '<ul class="secondary-navigation-menu-list">' . $childpages . '</ul>';
  }

  return $string;

}

/**
 * Add Theme Settings Page
 **/
function add_oese_theme_settings_menu(){
    add_theme_page("Theme Settings", "OESE Theme Settings", "edit_theme_options", "theme_settings_page",  "add_wp_oese_theme_settings_page", 10);
}
add_action( "admin_menu", "add_oese_theme_settings_menu" );

function add_wp_oese_theme_settings_page(){
    include( get_template_directory() . "/theme-functions/theme-settings.php");
}

/**
 * Theme Settings page
 **/
function wp_oese_theme_settings_page() {
        $page = "theme_settings_page";

  //Create Settings Section
  add_settings_section(
    'wp_oese_theme_settings',
    __('Modal', WP_OESE_THEME_SLUG),
    'wp_oese_theme_settings_callback',
    $page
  );

  //Add Settings field for Modal Heading
  add_settings_field(
    'wp_oese_theme_modal_heading',
    '',
    'wp_oese_theme_settings_field',
    $page,
    'wp_oese_theme_settings',
    array(
      'uid' => 'wp_oese_theme_modal_heading',
      'type' => 'textbox',
      'name' =>  __('Heading: ', WP_OESE_THEME_SLUG)
    )
  );

  //Add Settings field for Modal Content
  add_settings_field(
    'wp_oese_theme_modal_content',
    '',
    'wp_oese_theme_settings_field',
    $page,
    'wp_oese_theme_settings',
    array(
      'uid' => 'wp_oese_theme_modal_content',
      'type' => 'editor',
      'name' =>  __('Content: ', WP_OESE_THEME_SLUG)
    )
  );

  //Add Settings field to Enabled Redirect Modal
  add_settings_field(
    'wp_oese_theme_modal_enable_redirect',
    '',
    'wp_oese_theme_settings_field',
    $page,
    'wp_oese_theme_settings',
    array(
      'uid' => 'wp_oese_theme_modal_enable_redirect',
      'type' => 'checkbox',
      'name' =>  __('Enable redirect modal', WP_OESE_THEME_SLUG)
    )
  );

  //Add Settings field for Modal Heading
  add_settings_field(
    'wp_oese_theme_contact_page',
    '',
    'wp_oese_theme_select_contact_field',
    $page,
    'wp_oese_theme_settings',
    array(
      'uid' => 'wp_oese_theme_contact_page',
      'type' => 'selectbox',
      'name' =>  __('Contact Page: ', WP_OESE_THEME_SLUG)
    )
  );

  //Create GA Settings Section
  add_settings_section(
    'wp_oese_ga_settings',
    __('GA Settings', WP_OESE_THEME_SLUG),
    'wp_oese_theme_settings_callback',
    $page
  );

  //Enable UA tracking script
  add_settings_field(
    'wp_oese_theme_include_UA_tracking_script',
    '',
    'wp_oese_theme_settings_field',
    $page,
    'wp_oese_ga_settings',
    array(
      'uid' => 'wp_oese_theme_include_UA_tracking_script',
      'type' => 'checkbox',
      'name' =>  __('Enable UA Tracking', WP_OESE_THEME_SLUG)
    )
  );

  //Add GA Property ID Settings field
  add_settings_field(
    'wp_oese_theme_ga_propertyid',
    '',
    'wp_oese_theme_settings_field',
    $page,
    'wp_oese_ga_settings',
    array(
      'uid' => 'wp_oese_theme_ga_propertyid',
      'type' => 'textbox',
      'disabled' => (get_option('wp_oese_theme_include_UA_tracking_script')=="1"?false:true),
      'name' =>  __('UA Property ID: ', WP_OESE_THEME_SLUG)
    )
  );

  //Enable GA4 tracking script
  add_settings_field(
    'wp_oese_theme_include_GA4_tracking_script',
    '',
    'wp_oese_theme_settings_field',
    $page,
    'wp_oese_ga_settings',
    array(
      'uid' => 'wp_oese_theme_include_GA4_tracking_script',
      'type' => 'checkbox',
      'name' =>  __('Enable GA4 Tracking', WP_OESE_THEME_SLUG)
    )
  );

  //Add GA4 Property ID Settings field
  add_settings_field(
    'wp_oese_theme_ga4_propertyid',
    '',
    'wp_oese_theme_settings_field',
    $page,
    'wp_oese_ga_settings',
    array(
      'uid' => 'wp_oese_theme_ga4_propertyid',
      'type' => 'textbox',
      'disabled' => (get_option('wp_oese_theme_include_GA4_tracking_script')=="1"?false:true),
      'name' =>  __('GA4 Measurement ID: ', WP_OESE_THEME_SLUG)
    )
  );

  //Enable crazy egg tracking script
  add_settings_field(
    'wp_oese_theme_include_crazy_egg_script',
    '',
    'wp_oese_theme_settings_field',
    $page,
    'wp_oese_ga_settings',
    array(
      'uid' => 'wp_oese_theme_include_crazy_egg_script',
      'type' => 'checkbox',
      'name' =>  __('Enable Crazy Egg Tracking', WP_OESE_THEME_SLUG)
    )
  );

  //Crazy Egg Script Address
  add_settings_field(
    'wp_oese_theme_crazy_egg_script_address',
    '',
    'wp_oese_theme_settings_field',
    $page,
    'wp_oese_ga_settings',
    array(
      'uid' => 'wp_oese_theme_crazy_egg_script_address',
      'type' => 'textbox',
      'disabled' => (get_option('wp_oese_theme_include_crazy_egg_script')=="1"?false:true),
      'name' =>  __('Crazy Egg Script Address:', WP_OESE_THEME_SLUG)
    )
  );

  //Create PDF Embed Settings Section
  add_settings_section(
    'wp_oese_pdf_settings',
    __('PDF Embed Settings', WP_OESE_THEME_SLUG),
    'wp_oese_theme_settings_callback',
    $page
  );

  //Add PDF Viewer field
  add_settings_field(
    'wp_oese_theme_pdf_viewer',
    '',
    'wp_oese_theme_settings_field',
    $page,
    'wp_oese_pdf_settings',
    array(
      'uid' => 'wp_oese_theme_pdf_viewer',
      'type' => 'selectbox',
      'name' =>  __('Select PDF Viewer: ', WP_OESE_THEME_SLUG),
      'options' =>  array(
        "1" => "Google Viewer",
        "2" => "Mozilla PDFJS"
        ),
      'default' => '1'
    )
  );

  //Create Footer Settings Section
  add_settings_section(
    'wp_oese_footer_settings',
    __('Website Footer Settings', WP_OESE_THEME_SLUG),
    'wp_oese_theme_settings_callback',
    $page
  );

  //Add Display Address on Footer
  add_settings_field(
    'wp_oese_theme_display_footer_address',
    '',
    'wp_oese_theme_settings_field',
    $page,
    'wp_oese_footer_settings',
    array(
      'uid' => 'wp_oese_theme_display_footer_address',
      'type' => 'checkbox',
      'name' =>  __('Display Address in Footer', WP_OESE_THEME_SLUG)
    )
  );

  // Create NALRC Settings Section
  add_settings_section(
    'wp_oese_nalrc_settings',
    __('NALRC Settings', WP_OESE_THEME_SLUG),
    'wp_oese_theme_settings_callback',
    $page
  );

  // Add Header Menu Settings
  add_settings_field(
    'wp_oese_theme_nalrc_header',
    '',
    'wp_oese_theme_nalrc_menu_selectbox',
    $page,
    'wp_oese_nalrc_settings',
    array(
      'uid' => 'wp_oese_theme_nalrc_header',
      'type' => 'selectbox',
      'name' =>  __('Header Menu: ', WP_OESE_THEME_SLUG)
    )
  );

  // Add Header Menu Settings
  add_settings_field(
    'wp_oese_theme_nalrc_footer',
    '',
    'wp_oese_theme_nalrc_menu_selectbox',
    $page,
    'wp_oese_nalrc_settings',
    array(
      'uid' => 'wp_oese_theme_nalrc_footer',
      'type' => 'selectbox',
      'name' =>  __('Footer Menu: ', WP_OESE_THEME_SLUG)
    )
  );

  // Add Facebook URL Settings
  add_settings_field(
    'wp_oese_theme_nalrc_facebook',
    '',
    'wp_oese_theme_settings_field',
    $page,
    'wp_oese_nalrc_settings',
    array(
      'uid' => 'wp_oese_theme_nalrc_facebook',
      'type' => 'textbox',
      'name' =>  __('Facebook Url: ', WP_OESE_THEME_SLUG)
    )
  );

  // Add Twitter URL Settings
  add_settings_field(
    'wp_oese_theme_nalrc_twitter',
    '',
    'wp_oese_theme_settings_field',
    $page,
    'wp_oese_nalrc_settings',
    array(
      'uid' => 'wp_oese_theme_nalrc_twitter',
      'type' => 'textbox',
      'name' =>  __('Twitter Url: ', WP_OESE_THEME_SLUG)
    )
  );


  // Add Youtube URL Settings
  add_settings_field(
    'wp_oese_theme_nalrc_youtube',
    '',
    'wp_oese_theme_settings_field',
    $page,
    'wp_oese_nalrc_settings',
    array(
      'uid' => 'wp_oese_theme_nalrc_youtube',
      'type' => 'textbox',
      'name' =>  __('YouTube Url: ', WP_OESE_THEME_SLUG)
    )
  );

  // Add Instagram URL Settings
  add_settings_field(
    'wp_oese_theme_nalrc_instagram',
    '',
    'wp_oese_theme_settings_field',
    $page,
    'wp_oese_nalrc_settings',
    array(
      'uid' => 'wp_oese_theme_nalrc_instagram',
      'type' => 'textbox',
      'name' =>  __('Instagram Url: ', WP_OESE_THEME_SLUG)
    )
  );

  // Add Newsletter URL Settings
  add_settings_field(
    'wp_oese_theme_nalrc_newsletter',
    '',
    'wp_oese_theme_settings_field',
    $page,
    'wp_oese_nalrc_settings',
    array(
      'uid' => 'wp_oese_theme_nalrc_newsletter',
      'type' => 'textbox',
      'name' =>  __('Newsletter Url: ', WP_OESE_THEME_SLUG)
    )
  );

  // Add Other Settings section
  add_settings_section(
    'wp_oese_other_settings',
    __('Other Settings', WP_OESE_THEME_SLUG),
    'wp_oese_theme_settings_callback',
    $page
  );

  // Add Default Email settings
  add_settings_field(
    'wp_oese_theme_default_email',
    '',
    'wp_oese_theme_settings_field',
    $page,
    'wp_oese_other_settings',
    array(
      'uid' => 'wp_oese_theme_default_email',
      'type' => 'textbox',
      'name' =>  __('Default Email Address: ', WP_OESE_THEME_SLUG)
    )
  );

  register_setting( 'theme_settings_page' , 'wp_oese_theme_modal_heading' );
  register_setting( 'theme_settings_page' , 'wp_oese_theme_modal_content' );
  register_setting( 'theme_settings_page' , 'wp_oese_theme_modal_enable_redirect' );
  register_setting( 'theme_settings_page' , 'wp_oese_theme_contact_page' );
  register_setting( 'theme_settings_page' , 'wp_oese_theme_include_UA_tracking_script' );
  register_setting( 'theme_settings_page' , 'wp_oese_theme_ga_propertyid' );
  register_setting( 'theme_settings_page' , 'wp_oese_theme_include_GA4_tracking_script' );
  register_setting( 'theme_settings_page' , 'wp_oese_theme_ga4_propertyid' );
  register_setting( 'theme_settings_page' , 'wp_oese_theme_include_crazy_egg_script' );
  register_setting( 'theme_settings_page' , 'wp_oese_theme_crazy_egg_script_address' );
  register_setting( 'theme_settings_page' , 'wp_oese_theme_pdf_viewer' );
  register_setting( 'theme_settings_page' , 'wp_oese_theme_display_footer_address' );
  register_setting( 'theme_settings_page' , 'wp_oese_theme_nalrc_header' );
  register_setting( 'theme_settings_page' , 'wp_oese_theme_nalrc_footer' );
  register_setting( 'theme_settings_page' , 'wp_oese_theme_nalrc_facebook' );
  register_setting( 'theme_settings_page' , 'wp_oese_theme_nalrc_twitter' );
  register_setting( 'theme_settings_page' , 'wp_oese_theme_nalrc_youtube' );
  register_setting( 'theme_settings_page' , 'wp_oese_theme_nalrc_instagram' );
  register_setting( 'theme_settings_page' , 'wp_oese_theme_nalrc_newsletter' );
  register_setting( 'theme_settings_page' , 'wp_oese_theme_default_email' );
}
add_action( 'admin_init' , 'wp_oese_theme_settings_page' );

/**
 * Theme Settings Callback
 **/
function wp_oese_theme_settings_callback() {

}

/**
 * Theme Settings Field Callback
 **/
function wp_oese_theme_settings_field($arguments){
  $value = get_option($arguments['uid']);

  if ($arguments['type']=="textbox") {
    $disabled = false;
    if (isset($arguments['disabled']))
      $disabled = $arguments['disabled'];
    echo '<div class="form-row"><div class="form-group">
      <label for="'.$arguments['uid'].'"><strong>'.$arguments['name'].'</strong></label>
      <input name="'.$arguments['uid'].'" id="'.$arguments['uid'].'" type="'.$arguments['type'].'" value="' . $value . '" '.($disabled?'readonly':'').' />
    </div></div>';
  } elseif ($arguments['type']=="editor"){
    echo '<div class="form-row"><div class="form-group">
      <label for="'.$arguments['uid'].'"><strong>'.$arguments['name'].'</strong></label></div></div>';

    echo wp_editor($value, $arguments['uid'],array('media_buttons'=>false));

  } elseif ($arguments['type']=="checkbox"){
    echo '<div class="form-row"><div class="form-group">
      <input name="'.$arguments['uid'].'" id="'.$arguments['uid'].'" type="'.$arguments['type'].'" value="1" '.checked(1,$value,false).' />
      <label class="inline" for="'.$arguments['uid'].'"><strong>'.$arguments['name'].'</strong></label>
    </div></div>';
  } elseif ($arguments['type']=="selectbox"){
    if (isset($arguments['name']))
      $title = $arguments['name'];
      echo '<label for="'.$arguments['uid'].'"><strong>'.$title.'</strong></label>';
      echo '<select name="'.$arguments['uid'].'" id="'.$arguments['uid'].'">';

      if (isset($arguments['options']))
        $options = $arguments['options'];

      foreach($options as $key=>$desc){
        $selected = "";
        if ($value===false){
          if ($key==$arguments['default'])
            $selected = " selected";
        } else {
          if ($key==$value)
            $selected = " selected";
        }
        $disabled = "";
        echo '<option value="'.$key.'"'.$selected.''.$disabled.'>'.$desc.'</option>';
      }

      echo '<select>';
  }
}

function wp_oese_theme_select_contact_field($arguments){
    $value = get_option($arguments['uid']);

    // Get All Pages
    $args = array(
                'numberposts' => -1,
                'post_type' => 'page',
                'post_status' => 'publish',
                'orderby' => 'title',
                'order' => 'ASC'
                );
    $pages = get_posts($args);

    $post = get_post($value);
    $post_link = get_permalink($value);

    echo '<div class="form-row"><div class="form-group">
        <label for="'.$arguments['uid'].'"><strong>'.$arguments['name'].'</strong></label>';
    echo '<span class="contact-edit-link"><a href="'.$post_link.'" target="_blank">'.$post->post_title.'</a></span>
            <a class="contact-edit" href="javascript:void(0);"><span class="dashicons dashicons-edit"></span></a>';
    echo '<select name="'.$arguments['uid'].'" id="'.$arguments['uid'].'">';
    echo '<option value="">-- Please select contact page --</option>';
        foreach($pages as $page){
            echo '<option value="' . $page->ID . '" '.selected($page->ID,$value,true).'>'.$page->post_title.'</option>';
        }
    echo '</select>
    </div></div>';
}

// Select Menu for NALRC Header
function wp_oese_theme_nalrc_menu_selectbox($arguments){
  $value = get_option($arguments['uid']);
  $menus = wp_get_nav_menus();

  echo '<div class="form-row"><div class="form-group">';

  if (isset($arguments['name']))
      $title = $arguments['name'];

    echo '<label for="'.$arguments['uid'].'"><strong>'.$title.'</strong></label>';
    echo '<select name="'.$arguments['uid'].'" id="'.$arguments['uid'].'">';

    foreach($menus as $menu){
       echo '<option value="' . $menu->slug . '" '.selected($menu->slug,$value,true).'>'.$menu->name.'</option>';
    }

    echo '<select>';
  echo '</div></div>';
}

function wp_oese_theme_add_modal(){
  global $wp;
  $redirect = get_option('wp_oese_theme_modal_enable_redirect');
  if ($redirect=="1"){
    if (isset($_REQUEST['redirectold'])) {
      $modal_header = get_option('wp_oese_theme_modal_heading');
      $modal_content = get_option('wp_oese_theme_modal_content');
      include( get_template_directory() . "/inc/modal/redirect_modal.php");
    }
  }

}
add_action( 'wp_footer', 'wp_oese_theme_add_modal');

/**Csv import Media Library***/

function csvImportMediaForm(){
    $ajaxload = get_template_directory_uri() . '/images/ajax-load.gif';
    $samplecsvfile = get_template_directory_uri() . '/images/media-migration-sample.csv';

      echo '<div class="wrap">
            <div class="csv-media-import">
                <h2>WP Media Importer</h2>
                  <div class="form-section">
                    <div class="container">
                      <div class="error_message"></div>
                      <form name="wp_importer" class="importer"  method="post" enctype="multipart/form-data">
                      <div class="cfile">
                       Choose File
                        <input type="file" accept=".csv" name="fileToUpload" id="fileToUpload">
                      </div>
                      <div class="cfile-upload">
                        <input type="submit" class="button button-primary button-large" id="csv_media_upload" value="Upload Csv" name="submit">
                      </div>
                      </form>
                    </div>
                    <div class="c_file_name"></div>
                     <img style="display: none;" class="ajaxload" width="65" src="'.$ajaxload.'">
                    <div class=csv-sec>
                      <div class="samplecsv"><a class="csv_file" href="'.$samplecsvfile.'">Sample Csv</a>
                      </div>
                      <div class="outputcsv"></div>
                    </div>
                  </div>
                  <div class="results_table" style="display: none;">
                    <p class="page_count"></p>
                    <table class="fixed_header" id="page_result">
                      <thead>
                        <tr>
                          <th>Page Name</th>
                          <th>Action</th>
                        </tr>
                       </thead>
                    </table>

                  </div>
               </div>
            </div>';
}

  add_action('admin_menu', 'createCsvImportMenu' , 30);
  function createCsvImportMenu(){
    add_options_page( 'CSV Media Importer','CSV Media Importer','manage_options','csv-media-import.php','csvImportMediaForm');
  }

    function getUrlContents ($url) {
    $array = get_headers($url);
    $string = $array[0];
    if(strpos($string,"200")){
      if (function_exists('curl_exec')){
          $conn = curl_init($url);
          curl_setopt($conn, CURLOPT_SSL_VERIFYPEER, true);
          curl_setopt($conn, CURLOPT_FRESH_CONNECT,  true);
          curl_setopt($conn, CURLOPT_RETURNTRANSFER, 1);
          $url_get_contents_data = (curl_exec($conn));
          curl_close($conn);
      }elseif(function_exists('file_get_contents') && !$url_get_contents_data){
          $url_get_contents_data = file_get_contents($url);
      }elseif(function_exists('fopen') && function_exists('stream_get_contents') && !$url_get_contents_data){
          $handle = fopen ($url, "r");
          $url_get_contents_data = stream_get_contents($handle);
      }else{
          $url_get_contents_data = false;
      }
    }
    else{
      $url_get_contents_data = false;
    }
    return $url_get_contents_data;
  }


  function insertNewMedia($file,$title,$date,$mediaCat,$mediaTag, $mediaDescription, $mediaArchiveDate, $mediaPubID){
    if($file){
      $filename = basename($file);

      if ($title=="")
         $title = $filename;

      $data = getUrlContents($file);
      $attachment_id = "";
      if($data){
          $mediaDate = date("Y-m-d H:i:s");
          if(!empty($date)){
            if(checkDateFormat($date)){
              $mediaDate = date("Y-m-d H:i:s",strtotime($date));
            }
          }
          $wp_upload_dir = wp_upload_dir();
          $upload_file = wp_upload_bits($filename, null,$data);
          if (!$upload_file['error']) {
            $wp_filetype = wp_check_filetype($filename, null );
            $attachment = array(
              'post_mime_type' => $wp_filetype['type'],
              'post_title' => $title,
              'post_content' => $mediaDescription,
              'guid' => $wp_upload_dir['url'] . '/' . $filename ,
              'post_status' => 'inherit',
              'post_date'=>$mediaDate,
            );
            $attachment_id = wp_insert_attachment( $attachment, $upload_file['file']);

            if (!is_wp_error($attachment_id)) {
              require_once(ABSPATH . "wp-admin" . '/includes/image.php');
              require_once( ABSPATH . 'wp-admin' . '/includes/file.php' );
              require_once( ABSPATH . 'wp-admin' . '/includes/media.php' );
              $attachment_data = wp_generate_attachment_metadata( $attachment_id, $upload_file['file'] );
              wp_update_attachment_metadata( $attachment_id,  $attachment_data );

              /***Adding Category for media****/
              if($mediaCat){
                  $mediaCatArray = explode(";",$mediaCat);
                  $mediaCatArray = array_unique($mediaCatArray);
                  //print_r($mediaCatArray);
                  foreach ($mediaCatArray as $key => $catSlug) {
                      $catSlug = str_replace(' ', '', $catSlug);
                      $attachmentCatObj =  get_category_by_slug($catSlug);
                      if($attachmentCatObj){
                        $catId = $attachmentCatObj->term_id;
                      }
                      else{
                        $catId = wp_create_category($catSlug);
                      }
                      wp_set_post_categories($attachment_id,array($catId),true);
                  }

              }

              /***Adding Tags for media****/
              if($mediaTag){
                $mediaTagArray = explode(";",$mediaTag);
                $mediaTagArray = array_unique($mediaTagArray);
                  foreach ($mediaTagArray as $key => $tagSlug) {
                      $tagIdObj = term_exists($tagSlug,"post_tag");
                      if($tagIdObj['term_id']){
                        wp_set_post_tags($attachment_id,array($tagSlug),true);
                      }
                      else{
                        $termObj = wp_insert_term($tagSlug,"post_tag");
                        if($termObj){
                          wp_set_post_tags($attachment_id,array($tagSlug),true);
                        }
                      }
                  }
              }

              /** ACF Fields inserted **/
              if (function_exists('update_field')) {
                update_field('source_URL', $file, $attachment_id);
                if ($mediaArchiveDate)
                     update_field('archive_date', $mediaArchiveDate, $attachment_id);
                if ($mediaPubID)
                     update_field('publication_id', $mediaPubID, $attachment_id);
              }

            }
          }
        }

        /**Creating the output csv Array**/
        if($attachment_id){
          $attachmentUrl = wp_get_attachment_url($attachment_id);
          if(!$attachmentUrl)$attachmentUrl = "";
          return array('Success' => "TRUE", 'Url' => $file,'Date'=>$date,'Category'=>$mediaCat,'Tag'=>$mediaTag,'New Url'=>$attachmentUrl);
        }
        else{
           return array('Success' => "FAIL", 'Url' => $file,'Date'=>$date,'Category'=>$mediaCat,'Tag'=>$mediaTag,'New Url'=>"404 url not found");
        }
    }
    else{
      return array('Success' => "FAIL", 'Url' => $file,'Date'=>$date,'Category'=>$mediaCat,'Tag'=>$mediaTag,'New Url'=>"404 url not found");
    }
  }

  add_action('wp_ajax_csvMediaImport','csvMediaImport');

  function csvMediaImport(){
      error_reporting(E_ALL);
      ini_set('display_errors', 1);
      $csvImportFile = $_FILES['file']['tmp_name'];
      $csvAsArray = array_map('str_getcsv', file($csvImportFile));
      array_shift($csvAsArray);
      $outputCsv = array();
      foreach ($csvAsArray as $key => $csvVal) {
          $mediaUrl = $csvVal[0];
          $mediaTitle = $csvVal[1];
          $mediaCat = $csvVal[2];
          $mediaDate = $csvVal[3];
          $mediaTags = $csvVal[4];
          $mediaDescription = $csvVal[5];
          $mediaArchiveDate = $csvVal[6];
          $mediaPublicationID = $csvVal[7];

          $outputCsv[]= insertNewMedia($mediaUrl,$mediaTitle,$mediaDate,$mediaCat,$mediaTags, $mediaDescription, $mediaArchiveDate, $mediaPublicationID);
      }
     wp_send_json($outputCsv);
     die();
  }

  function checkDateFormat($date){
  $dt = DateTime::createFromFormat("Y-m-d", $date);
  return $dt !== false && !array_sum($dt::getLastErrors());
}

/**Csv import Media Library Ends***/

function oese_search_where($where){
    global $wpdb, $pagenow;
    if (in_array( $pagenow, array( 'upload.php', 'admin-ajax.php' ) ))
        return $where;

    if (is_search())
        $where .= "OR (t.name LIKE '%".get_search_query()."%' AND {$wpdb->posts}.post_status = 'publish')";
    return $where;
}
add_filter( "posts_where" , "oese_search_where" );

function oese_search_join($join){
    global $wpdb;
    if (is_search())
	$join .= "LEFT JOIN {$wpdb->term_relationships} tr ON ({$wpdb->posts}.ID = tr.object_id) LEFT JOIN {$wpdb->term_taxonomy} tt ON (tt.taxonomy = 'post_tag' AND tt.term_taxonomy_id=tr.term_taxonomy_id) LEFT JOIN {$wpdb->terms} t ON (tt.term_id = t.term_id)";
    return $join;
}
add_filter( "posts_join" , "oese_search_join" );

function oese_search_groupby($groupby){
    global $wpdb;

    // we need to group on post ID
    $groupby_id = "{$wpdb->posts}.ID";
    if(!is_search() || strpos($groupby, $groupby_id) !== false) return $groupby;

    // groupby was empty, use ours
    if(!strlen(trim($groupby))) return $groupby_id;

    // wasn't empty, append ours
    return $groupby.", ".$groupby_id;
}
add_filter('posts_groupby', 'oese_search_groupby');

function compareType($array1, $array2) {
  if ( $array1['typeId'] == $array2['typeId'] )
    return 0;
  if ( $array1['typeId'] < $array2['typeId'] )
    return -1;
  return 1;
}

function get_excerpt_by_id($post, $length=100) {
  $return_excerpt = function($post, $length) {
    if ($post->post_excerpt == '')
      return wp_trim_words($post->post_content, apply_filters( 'excerpt_length', $length ), apply_filters( 'excerpt_more', ' ' . '[&hellip;]' ));
    return $post->post_excerpt;
  };
  if (!is_object($post)) {
    $post = get_post($post);
  }
  return apply_filters('the_excerpt', $return_excerpt($post, $length));
}

add_filter( 'wpcf7_form_elements', function( $form ) {
  $page_name = "";
  if (isset($_GET['contact_reference'])){
    $page = get_post($_GET['contact_reference']);
    $page_name = $page->post_title;
  }
  $form = str_replace( 'Your Subject Here', $page_name, $form );
  return $form;
} );

function return_get_template_part($slug, $name=null) {

  ob_start();
  get_template_part($slug, $name);
  $content = ob_get_contents();
  ob_end_clean();

  return $content;
}

function oese_content_search_form($form){
  $form = return_get_template_part('content', 'searchform');
  return $form;
}

// PDF Embed Code using Google Viewer
function oese_pdf_embed_code($url, $viewer="google"){
  if ( $viewer=="google" ){
    $final_url = "https://docs.google.com/viewer?url=".$url."&embedded=true";
    $embed_code = '<iframe class="oer-pdf-viewer" width="100%" src="'.$final_url.'"></iframe>';
  } elseif( $viewer=="pdfjs" ){
    $pdf_url = get_template_directory_uri()."/pdfjs/web/viewer.html?file=".urlencode($url);
    $embed_code = '<iframe class="oer-pdf-viewer" width="100%" src="'.$pdf_url.'"></iframe>';
  }
  return $embed_code;
}


function oese_file_type_from_url($url, $class = 'fa-1x') {
  if(empty($url)) {
    return false;
  }

  $response = array();
  $oese_urls = explode('.', $url);
  $file_type = strtolower(end($oese_urls));
  if(in_array($file_type, ['jpg', 'jpeg', 'gif', 'png'])) {
    $response['title'] = 'Image';
    $response['icon'] = '<i class="far fa-file-image '.$class.'"></i>';
  } elseif($file_type == 'pdf') {
    $response['title'] = 'PDF';
    $response['icon'] = '<i class="far fa-file-pdf '.$class.'"></i>';
  } elseif(in_array($file_type, ['txt'])) {
    $response['title'] = 'Plain Text';
    $response['icon'] = '<i class="far fa-file-alt '.$class.'"></i>';
  } elseif(in_array($file_type, ['7z', 'zip', 'rar'])) {
    $response['title'] = 'Archive';
    $response['icon'] = '<i class="far fa-file-archive '.$class.'"></i>';
  } elseif(in_array($file_type, ['docx', 'doc'])) {
    $response['title'] = 'Microsoft Document';
    $response['icon'] = '<i class="far fa-file-word '.$class.'"></i>';
  } elseif(in_array($file_type, ['xls'])) {
    $response['title'] = 'Microsoft Excel';
    $response['icon'] = '<i class="far fa-file-excel '.$class.'"></i>';
  } elseif(in_array($file_type, ['ppt'])) {
    $response['title'] = 'Microsoft Powerpoint';
    $response['icon'] = '<i class="far fa-file-powerpoint '.$class.'"></i>';
  } elseif(in_array($file_type, ['wav', 'mp3'])) {
    $response['title'] = 'Audio';
    $response['icon'] = '<i class="far fa-file-audio '.$class.'"></i>';
  } elseif(in_array($file_type, ['mp4'])) {
    $response['title'] = 'Video';
    $response['icon'] = '<i class="far fa-file-video '.$class.'"></i>';
  }
  return $response;
}

function oese_ga_script() {
  $script = "";

  // Include GA
  $ua_enabled = get_option('wp_oese_theme_include_UA_tracking_script');
  $ua_id = get_option('wp_oese_theme_ga_propertyid');
  $ua_enabled = ($ua_enabled=="1"?true:false);
  $ga4_enabled = get_option('wp_oese_theme_include_GA4_tracking_script');
  $ga4_id = get_option('wp_oese_theme_ga4_propertyid');
  $ga4_enabled = ($ga4_enabled=="1"?true:false);
  $egg_script = get_option('wp_oese_theme_include_crazy_egg_script');
  $egg_script_address = get_option('wp_oese_theme_crazy_egg_script_address');

  // Include Crazy Egg Script
  if ($egg_script && !empty($egg_script_address)){
    $egg_script_address = preg_replace( "#^[^:/.]*[:/]+#i", "//", $egg_script_address );
    //$script .= "<script type='text/javascript' src='//s3.amazonaws.com/new.cetrk.com/pages/scripts/0009/9201.js'> </script>\r\n";
    $script .= "<script type='text/javascript' src='".$egg_script_address."' async='async'></script>";
  }

  if ($ga4_enabled && $ga4_id){
    $script .= "<script async src='https://www.googletagmanager.com/gtag/js?id=".$ga4_id."'></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', '".$ga4_id."');
        </script>";
  }

  if ($ua_enabled && $ua_id){
    /**--$script .= "<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', '".$ua_id."', 'auto');
    ga('send', 'pageview');
    </script>";--**/
    $script .= "<script async src='https://www.googletagmanager.com/gtag/js?id=".$ua_id."'></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', '".$ua_id."');
        </script>";
  }
  return $script;
}

// Get attachment ID by url
function oese_file_id_by_url($url) {
	global $wpdb;

	$file = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $url ));

        if ($file)
          return $file[0];
}

add_action( 'wp_footer' , 'add_bottom_script', 100 );
function add_bottom_script(){
   echo "<script type='text/javascript' src='". get_stylesheet_directory_uri() . "/js/bottom-script.js'></script>";
}


/*use wpsolr\core\classes\WPSOLR_Events;
use wpsolr\core\classes\extensions\localization\OptionLocalization;
use wpsolr\core\classes\ui\layout\checkboxes\WPSOLR_UI_Layout_Check_Box;
use wpsolr\core\classes\engines\WPSOLR_AbstractResultsClient;
use wpsolr\core\classes\ui\layout\WPSOLR_UI_Layout_Abstract;
use wpsolr\core\classes\utilities\WPSOLR_Option;
use wpsolr\core\classes\ui\WPSOLR_UI_Facets;
use wpsolr\core\classes\ui\WPSOLR_Query;
*/


add_action( 'after_setup_theme', function () {
    if (class_exists("wpsolr\\core\\classes\\WPSOLR_Events")) {
        add_action( wpsolr\core\classes\WPSOLR_Events::WPSOLR_ACTION_SOLARIUM_QUERY, 'oese_action_solarium_query', 10, 1 );
        add_action( wpsolr\core\classes\WPSOLR_Events::WPSOLR_FILTER_SOLR_RESULTS_APPEND_CUSTOM_HTML, 'oese_append_category_to_results_html', 10, 4);
    }
} );

function update_search_facet($html, $facets, $localization_options){
  $page_types = oese_get_page_types();
  $facets[] = $page_types;

  if (!empty($facets)){
    $facets_template = wpsolr\core\classes\extensions\localization\OptionLocalization::get_term( $localization_options, 'facets_element' );
    $facet_title     = wpsolr\core\classes\extensions\localization\OptionLocalization::get_term( $localization_options, 'facets_title' );

    foreach($facets as &$facet) {
      // Get the layout object
      $facet_layout_id = ( ! empty( $facet['facet_layout_id'] ) ) ? $facet['facet_layout_id'] : wpsolr\core\classes\ui\layout\checkboxes\WPSOLR_UI_Layout_Check_Box::CHILD_LAYOUT_ID;

      $layout_object = apply_filters( wpsolr\core\classes\WPSOLR_Events::WPSOLR_FILTER_LAYOUT_OBJECT, null, $facet_layout_id );

      if ( is_null( $layout_object ) ) {
        // Back to default layout
        $layout_object = new wpsolr\core\classes\ui\layout\checkboxes\WPSOLR_UI_Layout_Check_Box();
      }

      // Unique uuid for each facet. used to inject specific css/js to each facet.
      $facet_class_uuid = $layout_object->get_class_uuid();

      $facet_layout_skin_id = $layout_object->get_skin_id( $facet );

      if ( ! empty( $facet_layout_id ) ) {
        if ( 'wpsolr_no_skin' === $facet_layout_skin_id ) {
          // This facet is not to be displayed
          continue;
        } else {
          // Add layout javascript/css code and files
          $html .= $layout_object->generate_skin_js( $facet, $facet_class_uuid );
        }
      }

      $html .= sprintf( '<div class="wpsolr_facet_title %s_%s">%s</div>', wpsolr\core\classes\ui\layout\WPSOLR_UI_Layout_Abstract::CLASS_PREFIX, $facet['id'], sprintf( $facet_title, $facet['name'] ) );

      // Use the current facet template, else use the general facets template.
      $facet_template = ! empty( $facet['facet_template'] ) ? $facet['facet_template'] : $facets_template;

      $facet_grid = ! empty( $facet['facet_grid'] ) ? $facet['facet_grid'] : '';
      switch ( $facet_grid ) {
        case wpsolr\core\classes\utilities\WPSOLR_Option::OPTION_FACET_GRID_HORIZONTAL:
          $facet_grid_class = 'wpsolr_facet_column_horizontal';
          break;

        case wpsolr\core\classes\utilities\WPSOLR_Option::OPTION_FACET_GRID_1_COLUMN:
          $facet_grid_class = 'wpsolr_facet_columns wpsolr_facet_column_1';
          break;

        case wpsolr\core\classes\utilities\WPSOLR_Option::OPTION_FACET_GRID_2_COLUMNS:
          $facet_grid_class = 'wpsolr_facet_columns wpsolr_facet_column_2';
          break;

        case wpsolr\core\classes\utilities\WPSOLR_Option::OPTION_FACET_GRID_3_COLUMNS:
          $facet_grid_class = 'wpsolr_facet_columns wpsolr_facet_column_3';
          break;

        default;
          $facet_grid_class = ''; //'wpsolr_facet_columns wpsolr_facet_column_1';
          break;
      }

      $facet_grid_class .= ' wpsolr_facet_scroll';

      $facet['facet_layout_class']      = $layout_object->get_css_class_name();
      $facet['facet_layout_skin_class'] = $layout_object->get_css_skin_class_name( $facet['facet_layout_skin_id'] );

      $layout_object->displayFacetHierarchy( $facet_class_uuid, $facet_template, $facet_grid_class, $html, $facet, ! empty( $facet['items'] ) ? $facet['items'] : [] );

    }

    $is_facet_selected           = true;
    $remove_item_localization    = wpsolr\core\classes\extensions\localization\OptionLocalization::get_term( $localization_options, 'facets_element_all_results' );
    $is_generate_facet_permalink = apply_filters( wpsolr\core\classes\WPSOLR_Events::WPSOLR_FILTER_IS_GENERATE_FACET_PERMALINK, false );
    if ( $is_generate_facet_permalink ) {
      // Link to the current page or to the permalinks home ?

      $redirect_facets_home = apply_filters( wpsolr\core\classes\WPSOLR_Events::WPSOLR_FILTER_FACET_PERMALINK_HOME, '' );
      $html_remove_item     = sprintf( '<a class="wpsolr_permalink" href="%s" %s title="%s">%s</a>',
        ! empty( $redirect_facets_home ) ? ( '/' . $redirect_facets_home ) : './', '',
        $remove_item_localization, $remove_item_localization );

    } else {

      $html_remove_item = $remove_item_localization;
    }

    $html = sprintf( "<div><label class='wdm_label'>%s</label>
              <input type='hidden' name='sel_fac_field' id='sel_fac_field' >
              <div class='wdm_ul' id='wpsolr_section_facets'>
              <div class='%s'><div class='select_opt' id='wpsolr_remove_facets' data-wpsolr-facet-data='%s'>%s</div></div>",
                  wpsolr\core\classes\extensions\localization\OptionLocalization::get_term( $localization_options, 'facets_header' ),
                  'wpsolr_facet_checkbox' . ( $is_facet_selected ? ' checked' : '' ),
                  wp_json_encode( [ 'type' => wpsolr\core\classes\utilities\WPSOLR_Option::OPTION_FACET_FACETS_TYPE_FIELD ] ),
                  $html_remove_item
          )
          . $html;

    $html .= '</div></div>';
  }

  return $html;
}

function oese_get_page_types(){
  $facets = null;
  $templates = wp_get_theme()->get_page_templates();
  foreach ( $templates as $template_name => $template_filename ) {
    $facets[] = array( "value" => $template_name, "count" => get_count_by_template($template_name), "items" => null, "selected" => false, "value_localized" => $template_name );
  }

  return array(
          "items" => $facets,
          "id" => "_wp_page_template_str",
          "name" => "Page Type",
          "facet_type" => "facet_type_field",
          "facet_layout_id" => "",
          "facet_layout_skin_id" => "",
          "facet_grid" => "",
          "facet_size" => "",
          "facet_layout_skin_js" => "",
          "facet_placeholder" => ""
        );
}

function get_count_by_template($template_name) {
   $args = array(
        'post_type'  => array('page','post'), //or a post type of your choosing
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
            'key' => '_wp_page_template',
            'value' => $template_name,
            'compare' => '='
            )
        )
    );

    $query = new WP_Query($args);

    return count($query->posts);
}

// Update Search Query with Meta search
function update_search_query( $wpsolr_query ){
  $wpsolr_query->meta_query = array(
    array(
    'key' => '_wp_page_template',
    'value' => $template_name,
    'compare' => '='
    )
  );
  return $wpsolr_query;
}

// Add Page Template to Solr indexing
function add_page_template_to_document_for_update( array $document_for_update, $solr_indexing_options, $post, $attachment_body, wpsolr\core\classes\engines\WPSOLR_AbstractResultsClient $search_engine_client ) {
  $value = get_post_meta($post, '_wp_page_template');

  $solr_dynamic_type = WpSolrSchema::_SOLR_DYNAMIC_TYPE_STRING; // Depends on the type selected on your field on screen 2.2
  $document_for_update[ '_wp_page_template' . $solr_dynamic_type] = $value;

  return $document_for_update;
}

function oese_action_solarium_query( $parameters ) {
  /* @var WPSOLR_Query $wpsolr_query */
  $wpsolr_query = $parameters[ wpsolr\core\classes\WPSOLR_Events::WPSOLR_ACTION_SOLARIUM_QUERY__PARAM_WPSOLR_QUERY ];

  /* @var WPSOLR_AbstractSearchClient $search_engine_client */
  $search_engine_client = $parameters[ wpsolr\core\classes\WPSOLR_Events::WPSOLR_ACTION_SOLARIUM_QUERY__PARAM_SOLARIUM_CLIENT ];

  // post_type url parameter
  if ( ! empty( $wpsolr_query->query['post_type'] ) ) {
          $search_engine_client->search_engine_client_add_filter_term( sprintf( 'WPSOLR_Plugin_YITH_WooCommerce_Ajax_Search_Free type:%s', $wpsolr_query->query['post_type'] ), WpSolrSchema::_FIELD_NAME_TYPE, false, $wpsolr_query->query['post_type'] );
  }

}

function oese_add_category_to_results( wpsolr\core\classes\ui\WPSOLR_Query $wpsolr_query, wpsolr\core\classes\engines\WPSOLR_AbstractResultsClient $results ) {
  echo "<div style='display:none;'>";
  echo "</div>";
}

// Append New Search Result Item Layout
function oese_append_category_to_results_html( $default_html, $user_id, $document, wpsolr\core\classes\ui\WPSOLR_Query $wpsolr_query ) {
    $col_left = "";
    $col_right = "col-md-12";

    $result = '<div class="oese-search-result">';
    $result .= '<div class="oese-search-result-top row">';

    // Display page/post thumbnail
    $image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $document->id ) );
    if (!empty($image_url)){
        $col_left = 'col-md-3';
        $col_right = 'col-md-9';

        $result .= '<div class="oese-search-result-left '.$col_left.'">';
        $result .= "<img class='wdm_result_list_thumb' src='".$image_url[0]."' />";
        $result .= '</div>';
    }

    // Display title and display date
    $result .= '<div class="oese-search-result-right '.$col_right.'">';
    $url = get_permalink( $document->id );
    $result .= '<h4 class="p_title"><a href="'.$url.'">'.$document->title.'</a></h4>';
    $date = date( 'm/d/Y', strtotime( $document->displaymodified ) );;
    $result .= '<h5>'.$date.'</h5>';

    // Display Categories
    $result .= '<div class="oese-solr-category-block">';

    $categories = $document->categories_str;

    if (class_exists('WPSEO_Primary_Term')){
        // Show Primary category by Yoast if it is enabled & set
        $wpseo_primary_term = new WPSEO_Primary_Term( "category", $document->id );
        $primary_term = get_term($wpseo_primary_term->get_primary_term());

        if (!is_wp_error($primary_term)){
            $categories = $primary_term->name;
        }
    }

    if (!empty($categories)){
        $result .= '<div class="oese-solr-categories">';

        if (is_array($categories))
            $cat = implode(", ", $categories);
        else
            $cat = $categories;

        $result .= $cat;

        $result .= '</div>';
    }
    $result .= '</div>';
    $result .= '</div>';
    $result .= '</div>';

    // Display Post Content/Excerpt
    $result .= '<div class="oese-search-result-item-content">';
    $post_to_show = get_post( $document->id );
    if ( isset( $post_to_show ) ) {
        // Excerpt first, or content.
        $content = ( ! empty( $post_to_show->post_excerpt ) ) ? $post_to_show->post_excerpt : $post_to_show->post_content;

        global $post;
        $post    = $post_to_show;
        $content = do_shortcode( $content );

        $content = preg_replace( "~(?:\[/?)[^\]]+/?\]~s", '', $content );  # strip shortcodes, keep shortcode content;

        // Strip HTML and PHP tags
        $content = strip_tags( $content );

        $content = substr( $content, 0, 125 );

        // Format content text a little bit
        $content = str_replace( '&nbsp;', '', $content );
        $content = str_replace( '  ', ' ', $content );
        $content = ucfirst( trim( $content ) );
        $content .= '...';
        $result .= $content;
    }
    $result .= '</div>';

    $result .= '</div>';

    return $result;
}

// Replace WP Search with WP Solr
function replace_search_with_WP_Solr($result){
  $result = is_solr_installed();

  return $result;
}

function is_page_archived($page_id){
  $archived = false;

  if (get_field('archive_date', $page_id))
    $archived = true;

  return $archived;
}

// replace old urls with new WP Url
// param post_id_from and to for batch processing
function replace_page_old_urls($post_id_from=0,$post_id_to=0){
  // Select all pages with source URL
  $args = array(
    'post_type'  => array('page'), //page and attachment
    'posts_per_page' => -1, // select all pages
    'meta_key' => 'source_URL',
    'meta_value' => '',
    'meta_compare' => '!=',
    'post_status' => array('publish','inherit')
  );

  $query = new WP_Query($args);
  $relative_urls = oese_migrate_relative_urls();

  $i=1;
  foreach($query->posts as $post){
    //add filter to execute batch processing of replace
    if (($post_id_from==0 && $post_id_to==0) || (($post->ID <= $post_id_to) && ($post->ID >= $post_id_from))){

      // add counter check for source url post meta as WP_Query still returns other pages with space in source url
      $source_url = get_source_url($post->ID);
      if ($source_url !== ""){
        echo $i. '. ' .$post->ID . ' ';
        $content = $post->post_content;
        foreach($relative_urls as $old_url => $new_url){
          if (strpos($content, $old_url)){
            $content = str_replace('href="'.$old_url.'', 'href="'.$new_url.'', $content);
          }
        }

        //update post content
        $update_post = array('ID' => $post->ID,
                             'post_content' => $content );
        $updated_post_id = wp_update_post( $update_post, true );

        //check if error occurs during update
        if (is_wp_error($updated_post_id)) {
          $errors = $updated_post_id->get_error_messages();
          foreach ($errors as $error) {
                  echo $error;
          }
        } else {
          echo "Successfully updated ". $post->post_title ."<br/>";
        }
        $i++;
      }
    }
  }
}

// echo list of old urls to new WP Url for batch processing
function echo_migration_urls($indexes_only=false,$post_id_from=0,$post_id_to=0){
  $relative_urls = oese_migrate_relative_urls();
  foreach($relative_urls as $old_url => $new_url){
      if ( !$indexes_only || (substr($old_url, -10) == 'index.html') )
          echo $old_url.', '.$new_url."\n";
  }
}

// Get all pages with set source_URL
function oese_migrate_relative_urls(){
  $links = array();

  // Select all pages with source_URL
  $args = array(
    'post_type'  => array('page','attachment'), //page and attachment
    'posts_per_page' => -1, // select all pages
    'meta_key' => 'source_URL',
    'meta_value' => '',
    'meta_compare' => '!=',
    'post_status' => array('publish','inherit')
  );

  $query = new WP_Query($args);

  foreach($query->posts as $post){
    $old_url = get_source_url($post->ID);
    if ($post->post_type=="page")
      $new_url = get_the_permalink($post->ID);
    else
      $new_url = wp_get_attachment_url($post->ID);
    if ($old_url !== "")
      $links[$old_url] = $new_url;
  }

  return $links;
}

function get_source_url($post_id){
  $source = get_post_meta($post_id,'source_URL');
  if (is_array($source))
    return $source[0];
  return $source;
}

function update_oii_page_parent($parent_id, $category_slug){
  global $wpdb;

  // Select all pages with OII category and without parent page
  $args = array(
    'post_type'  => array('page', 'post'), //or a post type of your choosing
    'posts_per_page' => -1, // select all oii pages
    'category_name' => $category_slug,
    'post_parent' => 0
  );

  $query = new WP_Query($args);
  $i = 1;
  // Loop through oii pages and update parent id
  foreach($query->posts as $post){
    echo $i. '. ' .$post->ID . ' ';
    $update_post = array('ID' => $post->ID,
                         'post_parent' => $parent_id );
    $updated_post_id = wp_update_post( $update_post, true );
    if (is_wp_error($updated_post_id)) {
            $errors = $updated_post_id->get_error_messages();
            foreach ($errors as $error) {
                    echo $error;
            }
    } else {
      echo "Successfully updated ". $post->post_title ."<br/>";
    }
    $i++;
  }
}

function update_empty_page_to_draft($page_id_from=0, $page_id_to=0){
  global $wpdb;

  $args = array(
    'post_type'  => array('page'), //select all pages
    'posts_per_page' => -1, // select all pages
    'post_status' => array('publish')
  );

  $query = new WP_Query($args);
  $i=1;

  foreach ($query->posts as $post){
    if (($page_id_from==0 && $page_id_to==0) || (($post->ID <= $page_id_to) && ($post->ID >= $page_id_from))){
      if ($post->post_content==""){
        echo $i. '. ' .$post->ID . ' ';
        $update_post = array('ID' => $post->ID,
                        'post_status' => 'draft' );
        $updated_post_id = wp_update_post( $update_post, true );
        if (is_wp_error($updated_post_id)) {
          $errors = $updated_post_id->get_error_messages();
          foreach ($errors as $error) {
            echo $error;
          }
        } else {
          echo "Successfully updated ". $post->post_title ."<br/>";
        }
        $i++;
      }
    }
  }

}

add_action( "wp_footer" , "add_oese_inline_styles" );
function add_oese_inline_styles(){
  ?>
  <style type="text/css">
  .cls_search .ui-widget #searchsubmit {
    text-indent: -9999px;
    border: none;
    background:#1f5c99 url(<?php echo get_template_directory_uri()."/images/magnifying-glass-24.png"; ?>) no-repeat center center;
    height: 40px;
    width: 40px !important;
    border-top-right-radius: 5px;
    border-bottom-right-radius: 5px;
    cursor:pointer;
  }
  .cls_search .ui-widget #search_que {
    background: #f2f2f2;
    padding: 5px;
    border: 2px solid #cdcdcd;
    height: 40px !important;
    border-top-left-radius: 5px;
    border-bottom-left-radius: 5px;
  }
  </style>
  <?php
}

if (! function_exists('is_solr_installed')){
    function is_solr_installed(){
        $is_active = false;
        $active_plugins_basenames = get_option( 'active_plugins' );
        foreach ( $active_plugins_basenames as $plugin_basename ) {
		if ( false !== strpos( $plugin_basename, '/wpsolr-pro.php' ) ) {
                $is_active = true;
            }
        }
        return $is_active;
    }
}

// add filter for other file types to to Media Library
function oese_modify_post_mime_types( $post_mime_types ) {
    // select the mime type (e.g. 'application/pdf') then define an array with the label values
    $post_mime_types['application/pdf'] = array( __( 'PDFs' ), __( 'Manage PDFs' ), _n_noop( 'PDF <span class="count">(%s)</span>', 'PDFs <span class="count">(%s)</span>' ) );
    $post_mime_types['application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/msword'] = array('Word', 'Manage Word Docs', _n_noop('Word Doc <span class="count">(%s)</span>', 'Word Docs <span class="count">(%s)</span>'));
    $post_mime_types['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/msexcel,application/excel,application/vnd.ms-excel,application/x-excel,application/x-msexcel'] = array('Excel', 'Manage Excel Files', _n_noop('Excel File <span class="count">(%s)</span>', 'Excel Files <span class="count">(%s)</span>'));
    return $post_mime_types;
}
// Add Filter Hook
add_filter( 'post_mime_types', 'oese_modify_post_mime_types' );

function embedded_phpinfo()
{
    ob_start();
    phpinfo();
    $phpinfo = ob_get_contents();
    ob_end_clean();
    $phpinfo = preg_replace('%^.*<body>(.*)</body>.*$%ms', '$1', $phpinfo);
    echo "
        <style type='text/css'>
            #phpinfo {}
            #phpinfo pre {margin: 0; font-family: monospace;}
            #phpinfo a:link {color: #009; text-decoration: none; background-color: #fff;}
            #phpinfo a:hover {text-decoration: underline;}
            #phpinfo table {border-collapse: collapse; border: 0; width: 934px; box-shadow: 1px 2px 3px #ccc;}
            #phpinfo .center {text-align: center;}
            #phpinfo .center table {margin: 1em auto; text-align: left;}
            #phpinfo .center th {text-align: center !important;}
            #phpinfo td, th {border: 1px solid #666; font-size: 75%; vertical-align: baseline; padding: 4px 5px;}
            #phpinfo h1 {font-size: 150%;}
            #phpinfo h2 {font-size: 125%;}
            #phpinfo .p {text-align: left;}
            #phpinfo .e {background-color: #ccf; width: 300px; font-weight: bold;}
            #phpinfo .h {background-color: #99c; font-weight: bold;}
            #phpinfo .v {background-color: #ddd; max-width: 300px; overflow-x: auto; word-wrap: break-word;}
            #phpinfo .v i {color: #999;}
            #phpinfo img {float: right; border: 0;}
            #phpinfo hr {width: 934px; background-color: #ccc; border: 0; height: 1px;}
        </style>
        <div id='phpinfo'>
            $phpinfo
        </div>
        ";
}

if ( ! function_exists( 'oese_display_subpages' ) ) {
	/**
	 * Displays side navigation.
	 *
	 * @param  int $post_id The post ID.
	 * @return string
	 */
	function oese_display_subpages( $post_id ) {

        $html = "";
        $parent = false;
        $children = "";

        $args = array(
            'post_parent' => $post_id,
            'post_type'   => 'page',
            'numberposts' => -1,
            'post_status' => 'publish'
        );
        $post_children = get_children( $args );

        if ($post_children) {

            $html = '<ul class="oese-side-nav oese-side-nav-widget">';

            $children = wp_list_pages( 'title_li=&child_of=' . $post_id . '&depth=1&echo=0' );

            if ( $children ) {
                $html .= $children;
            }

            $html .= '</ul>';
        }

        return $html;
	}
}

function oet_display_acf_home_content(){
  if( have_rows('oet_acf_homepage_row') ):
    while ( have_rows('oet_acf_homepage_row') ) : the_row();

        $columnlayouts = array();
        if( get_row_layout() == '1_column_layout' ):
            $columnlayouts[0] = get_sub_field('oet_acf_homepage_column_1');
            foreach ($columnlayouts as $columnlayout) {  //Column FC
              ?><div class="col-sm-12 oet_1column_layout"><?php
              if(!empty($columnlayout)):
                foreach ($columnlayout as $subfieldlayout) { //Subfields FC w/in Column FC
                  if(!empty($subfieldlayout)):
                    foreach ($subfieldlayout as $subfieldkey => $subfieldvalue) {  //subfields within Subfield FC
                      if($subfieldkey !== 'acf_fc_layout'):
                        echo $subfieldvalue.'<br>';
                      endif;
                    }
                  endif;
                }
              endif;
              ?></div><?php
            }

        elseif( get_row_layout() == '2_column_layout' ):
            $columnlayouts[0] = get_sub_field('oet_acf_homepage_column_1');
            $columnlayouts[1] = get_sub_field('oet_acf_homepage_column_2');
            ?><div class="row col-sm-12 oet_acf_homepage_2column_layout ovlp"><?php
            foreach ($columnlayouts as $columnlayout) {  //Column FC
              ?><div class="col-sm-12 col-md-6 col-lg-6 oet_2column_layout"><?php
              if(!empty($columnlayout)):
                foreach ($columnlayout as $subfieldlayout) { //Subfields FC w/in Column FC
                  if(!empty($subfieldlayout)):
                    foreach ($subfieldlayout as $subfieldkey => $subfieldvalue) {  //subfields within Subfield FC
                      if($subfieldkey !== 'acf_fc_layout'):
                        echo $subfieldvalue;
                      endif;
                    }
                  endif;
                }
              endif;
              ?></div><?php
            }?></div><?php

        elseif( get_row_layout() == '2_column_layout_slider' ):
            $columnlayouts[0] = get_sub_field('oet_acf_homepage_column_1');
            $columnlayouts[1] = get_sub_field('oet_acf_homepage_column_2');

            ?>
            <div class="col-sm-12">
              <div class="row col-sm-12 custom-common-padding">
                <div class="col-sm-12 col-md-7 col-lg-7 oet_2column_layout"><?php
                  if(!empty($columnlayouts[0])):
                    foreach ($columnlayouts[0] as $subfieldlayout) { //Subfields FC w/in Column FC
                      if(!empty($subfieldlayout)):
                        foreach ($subfieldlayout as $subfieldkey => $subfieldvalue) {  //subfields within Subfield FC
                          if($subfieldkey !== 'acf_fc_layout'):
                            echo $subfieldvalue;
                          endif;
                        }
                      endif;
                    }
                  endif;
                ?>
                </div>
                <div class="col-sm-12 col-md-5 col-lg-5 oet_2column_layout"><?php
                  if(!empty($columnlayouts[1])):
                    foreach ($columnlayouts[1] as $subfieldlayout) { //Subfields FC w/in Column FC
                      if(!empty($subfieldlayout)):
                        foreach ($subfieldlayout as $subfieldkey => $subfieldvalue) {  //subfields within Subfield FC
                          if($subfieldkey !== 'acf_fc_layout'):
                            echo $subfieldvalue;
                          endif;
                        }
                      endif;
                    }
                  endif;
                ?>
                </div>
              </div>
            </div>
            <?php




        elseif( get_row_layout() == '3_column_layout' ):

            $columnlayouts[0] = get_sub_field('oet_acf_homepage_column_1');
            $columnlayouts[1] = get_sub_field('oet_acf_homepage_column_2');
            $columnlayouts[2] = get_sub_field('oet_acf_homepage_column_3');
            ?>

            <div class="col-sm-12 oet_3column_wrapper">
                <div class="row ovlp"><?php
                foreach ($columnlayouts as $columnlayout) {  //Column FC
                  ?><div class="col-sm-12 col-md-4 col-lg-4 oet_trendingnow_layout"><?php
                    if(!empty($columnlayout)):
                      foreach ($columnlayout as $subfieldlayout) { //Subfields FC w/in Column FC
                        if(!empty($subfieldlayout)):
                          foreach ($subfieldlayout as $subfieldkey => $subfieldvalue) {  //subfields within Subfield FC
                            if($subfieldkey !== 'acf_fc_layout'):
                              ?><div class="oet-trending-image pad"><?php
                              echo $subfieldvalue.'<br>';
                              ?></div><?php
                            endif;
                          }
                        endif;
                      }
                    endif;
                  ?></div>
                <?php } ?>
              </div>
            </div><?php

        elseif( get_row_layout() == 'oet_act_homepage_trendingnow' ):
            $sechead = get_sub_field('oet_acf_homepage_trendingnow_section_header');
            $columnlayouts[0] = get_sub_field('oet_acf_homepage_column_1');
            $columnlayouts[1] = get_sub_field('oet_acf_homepage_column_2');
            $columnlayouts[2] = get_sub_field('oet_acf_homepage_column_3');
            $columnlayouts[3] = get_sub_field('oet_acf_homepage_column_4');
            $columnlayouts[4] = get_sub_field('oet_acf_homepage_column_5');
            $columnlayouts[5] = get_sub_field('oet_acf_homepage_column_6');


            ?>
            <div class="col-sm-12">
              <div class="col-sm-12 custom-common-padding trending-now-acf">

                <div class="col-sm-12 oet_3column_wrapper">
                    <?php if($sechead !== '' && !empty($sechead)){ ?>

                      <div class="col-md-12">
                          <div class="row text-center">
                              <h2 class="h1-bottom-space trending-now-heading"><?php echo $sechead; ?></h2>
                          </div>
                      </div>

                    <?php } ?>
                    <div class="row ovlp"><?php
                    foreach ($columnlayouts as $columnlayout) {  //Column FC
                      ?><div class="col-sm-12 col-md-6 col-lg-4 mb-5 oet_trendingnow_layout"><?php
                        if(!empty($columnlayout)):
                        foreach ($columnlayout as $subfieldlayout) { //Subfields FC w/in Column FC
                          if(!empty($subfieldlayout)):
                          //print_r($subfieldlayout);
                            $_img = (isset($subfieldlayout['oet_acf_homepage_trendingnow_image']['id']))? $subfieldlayout['oet_acf_homepage_trendingnow_image']['id']: $subfieldlayout['oet_acf_homepage_trendingnow_image'];
                            $_img = wp_get_attachment_url( $_img);
                            $_img_alt = $subfieldlayout['oet_acf_homepage_trendingnow_image_alt_text'];
                            /*$_ico = $subfieldlayout['oet_acf_homepage_trendingnow_titleicon'];
                            $_title_icon = ($subfieldlayout['oet_acf_homepage_trendingnow_titleicon'] != 'none')? '<i class="fa '.$_ico.'"></i>&nbsp;': ''; */
                            $_title = $subfieldlayout['oet_acf_homepage_trendingnow_title'];
                            $_tmp = $subfieldlayout['oet_acf_homepage_trendingnow_description'];
                            $_desc = (strlen($_tmp)>210)? substr($_tmp,0,180).' ...': $_tmp;
                            $_url = $subfieldlayout['oet_acf_homepage_trendingnow_link'];
                            $_btntxt = $subfieldlayout['oet_acf_homepage_trendingnow_button_text'];
                            $_target = $subfieldlayout['oet_acf_homepage_trendingnow_link_newtab'];
                            if ($_target==true)
                              $_target = "_blank";
                            else
                              $_target = "_self";
                            ?>

                              <div class="oet_acf_homepage_trendingnow_block_wrapper">
                                  <div class="trending-now-section rounded">
                                      <div class="trending-image-section">
                                          <img src="<?php echo $_img; ?>" alt="<?php echo $_img_alt ?>">
                                      </div>
                                      <div class="trending-image-details">
                                          <h3 class="trending-image-details-title" title="<?php echo $_img_alt ?>"><?php echo $_title ?></h3>
                                          <p class="trending-image-details-description"><?php echo $_desc; ?></p>
                                          <a target="<?php echo $_target; ?>" href="<?php echo $_url; ?>" role="button" class="btn oese-btn-danger oese-btn-danger-small" title="Read More"><?php echo $_btntxt ?></a>
                                      </div>
                                  </div>
                              </div>

                            <?php
                          endif;
                        }
                        endif;
                      ?></div>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
            <?php

        elseif( get_row_layout() == 'oet_act_homepage_categories' ):
            $sechead = get_sub_field('oet_acf_homepage_category_section_header');
            $columnlayouts[0] = get_sub_field('oet_acf_homepage_column_1');
            $columnlayouts[1] = get_sub_field('oet_acf_homepage_column_2');
            $columnlayouts[2] = get_sub_field('oet_acf_homepage_column_3');


            ?>
            <div class="col-sm-12">
              <div class="col-sm-12 home-grid-section-acf">

                <div class="col-sm-12 oet_3column_wrapper oet_3column_wrapper_category">
                    <?php if($sechead !== '' && !empty($sechead)){ ?>

                      <div class="col-md-12">
                          <div class="row text-center">
                              <h2 class="h1-bottom-space trending-now-heading"><?php echo $sechead; ?></h2>
                          </div>
                      </div>

                    <?php } ?>
                    <div class="row ovlp"><?php
                    foreach ($columnlayouts as $columnlayout) {  //Column FC
                      ?><div class="col-sm-12 col-md-12 col-lg-4 mb-5 oet_category_layout"><?php
                        if(!empty($columnlayout)):
                        foreach ($columnlayout as $subfieldlayout) { //Subfields FC w/in Column FC
                          if(!empty($subfieldlayout)):
                          //print_r($subfieldlayout);
                            $_img = (isset($subfieldlayout['oet_acf_homepage_category_image']['id']))? $subfieldlayout['oet_acf_homepage_category_image']['id']: $subfieldlayout['oet_acf_homepage_category_image'];
                            $_img = wp_get_attachment_url( $_img);
                            $_img_alt = $subfieldlayout['oet_acf_homepage_category_image_alt_text'];
                            $_title = $subfieldlayout['oet_acf_homepage_category_title'];
                            $_url = $subfieldlayout['oet_acf_homepage_category_link'];
                            ?>





                              <div class="" style="width:100%; max-width:90%; margin:0px auto;">
                                <div class="custom-home-image-section">
                                  <div class="custom-image-media">
                                      <a target="_self" href="<?php echo $_url ?>">
                                          <div class="custom-image-thumbnail">
                                              <div>
                                                  <img src="<?php echo $_img ?>" alt="<?php echo $_img_alt ?>" class="img-responsive img-thumbnail-square">
                                              </div>
                                          </div>
                                          <div class="custom-home-image-heading text-center">
                                              <p><?php echo $_title ?></p>
                                          </div>
                                      </a>
                                  </div>
                              </div>
                            </div>






                            <?php
                          endif;
                        }
                        endif;
                      ?></div>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
            <?php


        elseif( get_row_layout() == 'oet_act_homepage_titlelinks' ):

            $tl_bg = get_sub_field('oet_acf_homepage_tilelinks_background');
            $tl_hds = get_sub_field('oet_acf_homepage_tilelinks_sectionheader_layout');
            $tl_lys[0] = get_sub_field('oet_act_homepage_tilelinks_quad1');
            $tl_lys[1] = get_sub_field('oet_act_homepage_tilelinks_quad2');
            $tl_lys[2] = get_sub_field('oet_act_homepage_tilelinks_quad3');
            $tl_lys[3] = get_sub_field('oet_act_homepage_tilelinks_quad4');

            $tl_bgimg_default = get_stylesheet_directory_uri().'/images/tile_links_default_background.png?default';
            if(!empty($tl_bg)){
              $tl_bgimg = (isset($tl_bg['oet_acf_homepage_titlelinks_background']['id']))? $tl_bg['oet_acf_homepage_titlelinks_background']['id']: $tl_bg;
              $tl_bgimg = wp_get_attachment_url( $tl_bgimg);
            }else{
              $tl_bgimg = $tl_bgimg_default;
            }

            ?>


            <div class="col-sm-12 oet_tilelinks_wrapper">
              <!--<div class="oet_tilelinks_background_overlay"></div>-->
              <div class="oet-tilelinks-content-wrapper">
              <?php if($tl_hds !== '' && !empty($tl_hds)){
                foreach ($tl_hds as $tl_hd) {
                  if(!empty($tl_hd)):
                    $tl_hdr_text = $tl_hd['oet_acf_homepage_tilelinks_sectionheader_text'];
                    $tl_hdr_fontsize = $tl_hd['oet_acf_homepage_titelinks_sectionheader_fontsize'];
                    $tl_hdr_fontcolor= $tl_hd['oet_acf_homepage_tilelinks_sectionheader_fontcolor'];
                    $tl_hdr_fontweight = $tl_hd['oet_acf_homepage_tilelinks_sectionheader_fontweight'];

                    if(!empty($tl_hdr_text)){
                    ?>
                    <div class="row"><h2 class="oet-tilelinks-section-title"><?php echo $tl_hdr_text; ?></h2></div>
                    <?php
                    }
                endif;
                ?>
                <style>
                .oet-tilelinks-section-title{
                  font-size: <?php echo $tl_hdr_fontsize ?>px;
                  color: <?php echo $tl_hdr_fontcolor ?>;
                  font-family:'WorkSans-<?php echo $tl_hdr_fontweight ?>' !important;
                }
                </style>
                <?php
                }
              }


              if($tl_lys !== '' && !empty($tl_lys)):
                ?><div class="row oet-tilelinks-button-section"><?php
                foreach ($tl_lys as $tl_ly):

                  $_titlelinks_layouts = get_sub_field('oet_act_homepage_tilelinks_quad1');
                  $lt_btn_text = $tl_ly[0]['oet_act_homepage_tilelinks_buttontext'];
                  $lt_btn_color = $tl_ly[0]['oet_act_homepage_tilelinks_buttoncolor'];
                  $lt_btn_fontcolor = $tl_ly[0]['oet_act_homepage_tilelinks_buttonfontcolor'];
                  $lt_btn_fontsize = $tl_ly[0]['oet_act_homepage_tilelinks_buttonfontsize'];
                  $lt_btn_url = $tl_ly[0]['oet_act_homepage_tilelinks_url'];
                  ?>
                      <div class="col-sm-12 col-md-6 oet-tilelinks-button-block">
                        <table border="0"><tr><td style="background-color:<?php echo $lt_btn_color ?> !important;" onclick="jQuery(this).children('a')[0].click();">
                          <a href="<?php echo ($lt_btn_url!='')? $lt_btn_url: '#'; ?>" style="color:<?php echo $lt_btn_fontcolor ?>; font-size:<?php echo $lt_btn_fontsize ?>px"><?php echo $lt_btn_text ?></a>
                        </td></tr></table>
                      </div>
                <?php
                endforeach;
                ?></div><?php
              endif; ?>




              </div>

            <style>
              .oet_tilelinks_wrapper::before {
                background-image: linear-gradient(rgba(44, 67, 116, 0.85), rgba(44, 67, 116, 0.85)), url(<?php echo $tl_bgimg ?>);
              }

            </style>
            </div>
            <?php



        elseif( get_row_layout() == 'oet_act_homepage_search' ):

            $_searchtitle = get_sub_field('oet_act_homepage_search_title');

            ?>
            <div class="col-sm-12 custom-common-padding">
              <div class="full-search-section m-auto text-center">
                   <div class="full-search-heading">
                       <h2><?php echo $_searchtitle ?></h2>
                   </div>

                   <div class="full-search-field">
                      <form id="searchformContent" class="searchform" action="<?php echo home_url(); ?>" method="get" role="search">
                          <div class="input-group to-focus">
                              <label class="search-label" for="inputSuccess2Content">Search:</label>
                              <input type="text" class="form-control full-search-input" id="inputSuccess2Content" placeholder="Search" name="s">
                              <div class="input-group-append">
                                  <button class="btn btn-secondary custom-search-btn" type="button" onclick="jQuery(this).closest('form').submit()">
                                  <i class="fas fa-search"></i><span class="search-button-label">Search</span>
                                  </button>
                              </div>
                          </div>
                      </form>
                  </div>
               </div>
             </div>
             <?php

        elseif( get_row_layout() == 'oet_act_homepage_spacer' ):
            $_sepacer_height = get_sub_field('oet_act_homepage_spacer_height');
            ?><div class="row col-sm-12" style="height:<?php echo $_sepacer_height.'px' ?>;"></div><?php

        elseif( get_row_layout() == 'oet_act_homepage_separator' ):
            ?>
              <div class="col-sm-12">
                <div class="seperate-dark-blue-border"></div>
              </div>
            <?php

        endif;


    // End loop.
    endwhile;
  endif;
}

function oese_add_home_detector()  {
  $d = is_front_page();
  if(isset($_GET['post'])){
      if(get_option("page_on_front") == $_GET['post']){
        $_str = '';
        $_str .= '<script>';
        $_str .= 'jQuery(document).ready(function(){';
            $_str .= 'jQuery("body").addClass("home");';
        $_str .= '});';
        $_str .= '</script>';
        echo $_str;
      }
  }
}
add_action( 'admin_footer', 'oese_add_home_detector' );

/**
 * Restore CSV upload functionality for WordPress 4.9.9 and up
 */
add_filter('wp_check_filetype_and_ext', function($values, $file, $filename, $mimes) {
	if ( extension_loaded( 'fileinfo' ) ) {
		// with the php-extension, a CSV file is issues type text/plain so we fix that back to
		// text/csv by trusting the file extension.
		$finfo     = finfo_open( FILEINFO_MIME_TYPE );
		$real_mime = finfo_file( $finfo, $file );
		finfo_close( $finfo );

		if ( $real_mime === 'text/plain' && preg_match( '/\.(csv)$/i', $filename ) ) {
			$values['ext']  = 'csv';
			$values['type'] = 'text/csv';
		}
	} else {
		// without the php-extension, we probably don't have the issue at all, but just to be sure...
		if ( preg_match( '/\.(csv)$/i', $filename ) ) {
			$values['ext']  = 'csv';
			$values['type'] = 'text/csv';
		}
	}

	return $values;
}, PHP_INT_MAX, 4);

/**
 * Include Slider
 */
include( get_template_directory() . "/modules/oese-acf-slider/oese-acf-slider.php");

/* ENABLE GUTENBERG EDITOR */
$GLOBALS['oese_is_gutenberg_active'] = 'true';  // use "true" to activate gutenberg editor

/* PREVIEW CAPABILITY */
//add_filter('use_block_editor_for_post', '__return_'.$GLOBALS['oese_is_gutenberg_active'], 10);
if ( $GLOBALS['oese_is_gutenberg_active'] == 'true') { // Use this in Gutenberg
    include( get_template_directory() . "/modules/oesepreview/oesepreviewguten.php");
}else{ // Use this on classic
    include( get_template_directory() . "/modules/oesepreview/oesepreview.php");
}

/*
* Add OER Block Category
*/
function oese_block_category( $categories ) {
	$category_slugs = wp_list_pluck( $categories, 'slug' );
	return in_array( 'oese-block-category', $category_slugs, true ) ? $categories : array_merge(
        array(
            array(
				'slug' => 'oese-block-category',
				'title' => __( 'OESE Blocks', 'oese-block-category' ),
			),
        ),
        $categories
    );
}
add_filter( 'block_categories', 'oese_block_category', 10, 2);


/** Add Link to Media Button on Rich Text Editor Block **/
add_action('enqueue_block_editor_assets', 'oese_block_editor_text_link_to_media');
function oese_block_editor_text_link_to_media() {

  // Load the compiled blocks into the editor.
  wp_enqueue_script(
    'link-to-media-button-js',
    get_stylesheet_directory_uri().'/js/link-to-media.js',
    array( 'wp-blocks', 'wp-element', 'wp-components', 'wp-editor' ),
    '1.0',
    true
  );

  // Load the compiled styles into the editor.
  wp_enqueue_style(
    'link-to-media-css',
    get_stylesheet_directory_uri().'/css/link-to-media.css',
    array( 'wp-edit-blocks' )
  );
}

/** Update TinyMCE Advance Font Sizes Selection **/
if ( ! function_exists( 'oese_tiny_mce_font_sizes' ) ) {
  function oese_tiny_mce_font_sizes( $initArray ){
    $initArray['fontsize_formats'] = "8px 9px 10px 11px 12px 14px 16px 18px 20px 24px 28px 32px 36px 48px 60px 72px";
    return $initArray;
  }
}
add_filter( 'tiny_mce_before_init', 'oese_tiny_mce_font_sizes' );

/** Tile Links Block using ACF Blocks **/
function oese_acf_init_tile_links_block(){
  if (function_exists('acf_register_block')){
    // register a tile link block
    acf_register_block(array(
      'name'            => 'tile-link',
      'title'           => __('Tile Links'),
      'description'     => __('A tile link block.'),
      'render_callback' => 'oese_tile_link_block_render_callback',
      'category'        => 'oese-block-category',
      'icon'            => 'admin-links',
      'keywords'        => array( 'tile link', 'link' ),
      'enqueue_style'   => get_stylesheet_directory_uri() . '/css/block/tile-link.css',
      'example'  => array(
        'attributes' => array(
            'mode' => 'preview',
            'data' => array(
              'tile_links' => array(
                'tile_link_title'   => "Lorem Ipsum",
                'tile_link_url'     => "https://example.com",
                'external_link'     => "True",
                'width'             => "full"
              )
            )
        )
      )
    ));
  }
}
add_action( 'acf/init', 'oese_acf_init_tile_links_block' );

function oese_tile_link_block_render_callback( $block ){
  $slug = str_replace('acf/', '', $block['name']);

  // include a template part from within the "template-parts/block" folder
  if( file_exists( get_theme_file_path("/template-parts/block/content-{$slug}.php") ) ) {
    include( get_theme_file_path("/template-parts/block/content-{$slug}.php") );
  }
}


// Disable access to wp-json from the outside and allow it only for logged in users(WP Admin dashboard)
function oese_disable_rest_api_from_public($result){
  // If a previous authentication check was applied, pass that result along without modification.
  if ( true === $result || is_wp_error( $result ) ) {
      return $result;
  }

  if (false !== strpos( esc_url_raw($_SERVER['REQUEST_URI']), '/wp-json/contact-form-7' )) {
      return $result;
  }

  // Return an error if user is not logged in or if not Contact Form 7 Rest API endpoint.
  if ( ! is_user_logged_in() ) {
      return new WP_Error(
          'rest_not_logged_in',
          __( 'You are not currently logged in.' ),
          array( 'status' => 401 )
      );
  }


  // no effect on logged-in requests
  return $result;
}
add_filter( 'rest_authentication_errors' , 'oese_disable_rest_api_from_public' );


/** Add NALRC ACF Slider Options Page **/
function oese_add_nalrc_slider_settings(){
  if (function_exists('acf_add_options_sub_page')){
    acf_add_options_sub_page(array(
      'page_title' => 'NALRC Slider Settings',
      'menu_title' => 'NALRC Slider',
      'parent_slug' => 'themes.php',
    ));
  }
}
add_action('acf/init', 'oese_add_nalrc_slider_settings');

// Order metaboxes(OER, Script N' Styles, WP SEO)
$_nalrc = true;
if ($_nalrc){
  add_filter( 'get_user_option_meta-box-order_resource', 'oese_reorder_metaboxes' );
  function oese_reorder_metaboxes( $order ) {
      return array(
          'normal' => join(
              ",",
              array(
                  'oer_metaboxid',
                  'SnS_meta_box',
                  'wpseo_meta'
              )
          ),
      );
  }
}

// Checks WP version
if (!function_exists('is_version58')) {
    function is_version58(){
        if ( version_compare( $GLOBALS['wp_version'], '5.8-alpha-1', '<' ) ) {
            return false;
        } else {
            return true;
        }
    }
}

function oese_admin_body_template_class( $str_classes ) {
    global $post;
    $template_slug = get_page_template_slug( $post );
    $classes   = explode(' ', $str_classes);
    $classes[] = str_replace(".php","",str_replace("/","_",$template_slug));
    $new_str_classes = join(' ', $classes);
    return $new_str_classes;
}
add_filter( 'admin_body_class', 'oese_admin_body_template_class' );
