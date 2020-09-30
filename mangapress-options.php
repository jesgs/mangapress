<?php
/**
 * MangaPress
 *
 * @package mangapress-options
 * @author Jess Green <jgreen at psy-dreamer.com>
 * @version $Id$
 * @license GPL
 */
/**
 * mangapress-options
 *
 * @author Jess Green <jgreen at psy-dreamer.com>
 */
final class MangaPress_Options
{
    const OPTIONS_GROUP_NAME = 'mangapress_options';

    /**
     * Default options array
     *
     * @var array
     */
    protected static $_default_options =  array(
        'basic' => array(
        	'enable_beta_features'    => 0,
            'latestcomic_page'        => 0,
            'group_comics'            => 0,
            'group_by_parent'         => 0,
            'comicarchive_page'       => 0,
            'comicarchive_page_style' => 'list',
            'archive_order'           => 'DESC',
            'archive_orderby'         => 'date',
        ),
        'comic_page' => array(
            'generate_comic_page' => 0,
            'comic_page_width'    => 600,
            'comic_page_height'   => 1000,
        ),
        'nav' => array(
            'nav_css'    => 'custom_css',
        ),
    );

    /**
     * PHP5 Constructor function
     * 
     * @return void
     */
    public function __construct()
    {
        add_action('admin_init', array($this, 'admin_init'));
    }

    /**
     * Run admin_init functions
     *
     * @return void
     */
    public function admin_init()
    {

        if (defined('DOING_AJAX') && DOING_AJAX)
              return;

        register_setting(
            self::OPTIONS_GROUP_NAME,
            self::OPTIONS_GROUP_NAME,
            array($this, 'sanitize_options')
        );

        // register settings section
        $sections = $this->options_sections();
        foreach ($sections as $section_name => $data) {
            add_settings_section(
                self::OPTIONS_GROUP_NAME . "-{$section_name}",
                $data['title'],
                array($this, 'settings_section_cb'),
                self::OPTIONS_GROUP_NAME . "-{$section_name}"
            );
        }

        // output settings fields
        $this->output_settings_fields();
    }

    /**
     * Outputs the settings fields
     *
     * @return void
     */
    public function output_settings_fields()
    {
        $admin = MangaPress_Bootstrap::get_instance()->get_helper('admin');

        $field_sections = $this->options_fields();
        $current_tab    = $admin->get_current_tab();
        $fields         = $field_sections[$current_tab];

        foreach ($fields as $field_name => $field) {
            add_settings_field(
                "{$current_tab}-options-{$field['id']}",
                (isset($field['title']) ? $field['title'] : " "),
                $field['callback'],
                "mangapress_options-{$current_tab}",
                "mangapress_options-{$current_tab}",
                array_merge(array('name' => $field_name, 'section' => $current_tab), $field)
            );
        }
    }


    /**
     * Call-back for outputting settings fields
     *
     * @param array $option Current option array
     * @return void
     */
    public function settings_field_cb($option)
    {
        $mp_options = MangaPress_Bootstrap::get_instance()->get_options();

        $class = ucwords($option['type']);
        $value = isset($mp_options[$option['section']][$option['name']])
            ? $mp_options[$option['section']][$option['name']]
            : self::$_default_options[$option['section']][$option['name']];

        if ($class !== ""){
            $attributes  = array(
                'name'  => "mangapress_options[{$option['section']}][{$option['name']}]",
                'id'    => $option['id'],
                'value' => $value,
            );

            $element = "MangaPress_{$class}";
            echo new $element(array(
                'attributes'  => $attributes,
                'description' => isset($option['description']) ? $option['description'] : '',
                'default'     => isset($option['value']) ? $option['value'] : $option['default'],
                'validation'  => $option['valid']
            ));
        }
    }

    /**
     * Call-back for outputting settings fields (select drop-downs)
     * with custom values.
     *
     * @param array $option Current option array
     * @return void
     */
    public function ft_basic_page_dropdowns_cb($option)
    {

        $mp_options = MangaPress_Bootstrap::get_instance()->get_options();

        $value = $mp_options[$option['section']][$option['name']];

        $pages   = get_pages();
        $options = array_merge(array(), $option['value']);
        foreach($pages as $page) {
            $options[$page->post_name] = $page->post_title;
        }

        echo new MangaPress_Select(array(
            'attributes'  => array(
                'name'  => "mangapress_options[{$option['section']}][{$option['name']}]",
                'id'    => $option['id'],
                'value' => $value,
            ),
            'description' => isset($option['description']) ? $option['description'] : '',
            'default'     => $options,
            'validation'  => $option['valid']
        ));

    }

    /**
     * Call-back for outputting settings fields display box
     *
     * @param array $option Optional. Current option array
     * @return void
     */
    public function ft_navigation_css_display_cb($option = array())
    {
        require_once MP_ABSPATH . 'includes/pages/nav-css.php';
    }

    /**
     * settings_section_cb()
     * Outputs Settings Sections
     *
     * @param string $section Name of section
     * @return void
     */
    public function settings_section_cb($section)
    {
        $options = $this->options_sections();
        $current = (substr($section['id'], strpos($section['id'], '-') + 1));
        echo "<p>{$options[$current]['description']}</p>";
    }


    /**
     * Returns default options
     * Used by MangaPress_Install to handle defaults on activation
     *
     * @return array
     */
    public static function get_default_options()
    {
        return self::$_default_options;
    }

    /**
     * Helper function for creating default options fields.
     *
     * @return array
     */
    public function options_fields()
    {
        /*
         * Section
         *      |_ Option
         *              |_ Option Setting
         */
        $options = array(
            'basic' => array(
	            'enable_beta_features'      => array(
		            'id'          => 'enable-beta-features',
		            'type'        => 'checkbox',
		            'title'       => __('Enable Beta Features', MP_DOMAIN),
		            'valid'       => 'boolean',
		            'description' => __(
		            	sprintf(
		            		'Enable preview features from the next version. WARNING: Use at own risk. You must download the Feature Plugin of your choice to use this feature. Feature plugins are available [<a href="%s" target="_blank" rel="noopener">here</a>]',
				            'https://manga-press.com/blog/category/beta-testing/'
			            ), MP_DOMAIN),
		            'default'     => 1,
		            'callback'    => array($this, 'settings_field_cb'),
	            ),
                'latestcomic_page'  => array(
                    'id'    => 'latest-comic-page',
                    'type'  => 'select',
                    'title' => __('Latest Comic Page', MP_DOMAIN),
                    'value' => array(
                        'no_val' => __('Select a Page', MP_DOMAIN),
                    ),
                    'valid' => 'array',
                    'default'  => 0,
                    'callback' => array($this, 'ft_basic_page_dropdowns_cb'),
                ),
                'group_comics'      => array(
                    'id'    => 'group-comics',
                    'type'  => 'checkbox',
                    'title' => __('Group Comics', MP_DOMAIN),
                    'valid' => 'boolean',
                    'description' => __('Group comics by category. This option will ignore the parent category, and group according to the child-category.', MP_DOMAIN),
                    'default' => 1,
                    'callback' => array($this, 'settings_field_cb'),
                ),
                'group_by_parent'      => array(
                    'id'    => 'group-by-parent',
                    'type'  => 'checkbox',
                    'title' => __('Use Parent Category', MP_DOMAIN),
                    'valid' => 'boolean',
                    'description' => __('Group comics by top-most parent category. Use this option if you have sub-categories but want your navigation to function using the parent category.', MP_DOMAIN),
                    'default'     => 1,
                    'callback'    => array($this, 'settings_field_cb'),
                ),
                'comicarchive_page' => array(
                    'id'    => 'archive-page',
                    'type'  => 'select',
                    'title' => __('Comic Archive Page', MP_DOMAIN),
                    'value' => array(
                        'no_val' => __('Select a Page', MP_DOMAIN),
                    ),
                    'valid' => 'array',
                    'default' => 0,
                    'callback' => array($this, 'ft_basic_page_dropdowns_cb'),
                ),
                'comicarchive_page_style' => array(
                    'id'    => 'archive-page-style',
                    'type'  => 'select',
                    'title' => __('Comic Archive Page Style', MP_DOMAIN),
                    'description' => __('Style used for comic archive page. List, Calendar, or Gallery. Default: List', MP_DOMAIN),
                    'value' => array(
                        'no_val' => __('Select a Style', MP_DOMAIN),
                        'list'   => __('List', MP_DOMAIN),
                        'calendar' => __('Calendar', MP_DOMAIN),
                        'gallery' => __('Gallery', MP_DOMAIN),
                    ),
                    'valid'   => 'array',
                    'default' => 'list',
                    'callback'    => array($this, 'settings_field_cb'),
                ),
                'archive_order'    => array(
                    'id'     => 'order',
                    'title'  => __('Archive Page Comic Order', MP_DOMAIN),
                    'description' => __('Designates the ascending or descending order of the orderby parameter', MP_DOMAIN),
                    'type'   => 'select',
                    'value'  => array(
                        'ASC'  => __('ASC', MP_DOMAIN),
                        'DESC' => __('DESC', MP_DOMAIN),
                    ),
                    'valid'   => 'array',
                    'default' => 'DESC',
                    'callback' => array($this, 'settings_field_cb'),
                ),
                'archive_orderby'    => array(
                    'id'     => 'orderby',
                    'title'  => __('Archive Page Comic Order By', MP_DOMAIN),
                    'description' => __('Sort retrieved posts according to selected parameter.', MP_DOMAIN),
                    'type'   => 'select',
                    'value'  => array(
                        'ID'       => __('Order by Post ID', MP_DOMAIN),
                        'author'   => __('Order by author', MP_DOMAIN),
                        'title'    => __('Order by title', MP_DOMAIN),
                        'name'     => __('Order by post name (post slug)', MP_DOMAIN),
                        'date'     => __('Order by date.', MP_DOMAIN),
                        'modified' => __('Order by last modified date.', MP_DOMAIN),
                        'rand'     => __('Random order', MP_DOMAIN),
                    ),
                    'valid'   => 'array',
                    'default' => 'date',
                    'callback' => array($this, 'settings_field_cb'),
                ),
            ),
            'comic_page' => array(
                'generate_comic_page' => array(
                    'id'    => 'generate-page',
                    'type'  => 'checkbox',
                    'title'       => __('Generate Comic Page', MP_DOMAIN),
                    'description' => __('Generate a comic page based on values below.', MP_DOMAIN),
                    'valid'       => 'boolean',
                    'default'     => 1,
                    'callback' => array($this, 'settings_field_cb'),
                ),
                'comic_page_width'    => array(
                    'id'    => 'page-width',
                    'type'  => 'text',
                    'title'   => __('Comic Page Width', MP_DOMAIN),
                    'valid'   => '/[0-9]/',
                    'default' => 600,
                    'callback' => array($this, 'settings_field_cb'),
                ),
                'comic_page_height'   => array(
                    'id'    => 'page-height',
                    'type'  => 'text',
                    'title'   => __('Comic Page Height', MP_DOMAIN),
                    'valid'   => '/[0-9]/',
                    'default' => 1000,
                    'callback' => array($this, 'settings_field_cb'),
                ),
            ),
            'nav' => array(
                'nav_css'    => array(
                    'id'     => 'navigation-css',
                    'title'  => __('Navigation CSS', MP_DOMAIN),
                    'description' => __('Include the default CSS for the navigation. Set to Custom CSS (which uses styles defined by the theme).', MP_DOMAIN),
                    'type'   => 'select',
                    'value'  => array(
                        'custom_css' => __('Custom CSS', MP_DOMAIN),
                        'default_css' => __('Default CSS', MP_DOMAIN),
                    ),
                    'valid'   => 'array',
                    'default' => 'custom_css',
                    'callback' => array($this, 'settings_field_cb'),
                ),
                'display_css' => array(
                    'id'       => 'display',
                    'callback' => array($this, 'ft_navigation_css_display_cb'),
                )
            ),
        );

        return apply_filters('mangapress_options_fields', $options);
    }

    /**
     * Helper function for setting default options sections.
     *
     * @return array
     */
    public function options_sections()
    {
        $sections = array(
            'basic'      => array(
                'title'       => __('Basic Options', MP_DOMAIN),
                'description' => __('This section sets the &ldquo;Latest-&rdquo; and &ldquo;Comic Archive&rdquo; pages, number of comics per page, and grouping comics together by category.', MP_DOMAIN),
            ),
            'comic_page' => array(
                'title'       => __('Comic Page Options', MP_DOMAIN),
                'description' => __('Handles image sizing options for comic pages. Thumbnail support may need to be enabled for some features to work properly. If page- or thumbnail sizes are changed, then a plugin such as Regenerate Thumbnails may be used to create the new thumbnails.', MP_DOMAIN),
            ),
            'nav'        => array(
                'title'       => __('Navigation Options', MP_DOMAIN),
                'description' => __('Options for comic navigation. Whether to have navigation automatically inserted on comic pages, or to enable/disable default comic navigation CSS.', MP_DOMAIN),
            ),
        );

        return apply_filters('mangapress_options_sections', $sections);
    }


    /**
     * Get option sections. Returned as an array based on the array keys from $sections
     *
     * @return array
     */
    public function get_options_sections()
    {
        return array_keys($this->options_sections());
    }


    /**
     * Sanitize options
     *
     * @param array $options
     * @return array
     */
    public function sanitize_options($options)
    {
        if (!$options)
            return $options;

        $mp_options        = MangaPress_Bootstrap::get_instance()->get_options();
        $section           = key($options);
        $available_options = $this->options_fields();
        $new_options       = $mp_options;

        if ($section == 'nav'){
            //
            // if the value of the option doesn't match the correct values in the array, then
            // the value of the option is set to its default.
            $nav_css_values = array_keys($available_options['nav']['nav_css']['value']);

            if (in_array($mp_options['nav']['nav_css'], $nav_css_values)){
                $new_options['nav']['nav_css'] = strval($options['nav']['nav_css']);
            } else {
                $new_options['nav']['nav_css'] = 'default_css';
            }
        }

        if ($section == 'basic') {
            $archive_order_values = array_keys($available_options['basic']['archive_order']['value']);
            $archive_orderby_values = array_keys($available_options['basic']['archive_orderby']['value']);
            //
            // Converting the values to their correct data-types should be enough for now...
            $new_options['basic'] = array(
            	'enable_beta_features'    => intval($options['basic']['enable_beta_features']),
                'archive_order'   => in_array($options['basic']['archive_order'], $archive_order_values)
                                        ? $options['basic']['archive_order']
                                        : $available_options['basic']['archive_order']['default'],
                'archive_orderby'   => in_array($options['basic']['archive_orderby'], $archive_orderby_values)
                                        ? $options['basic']['archive_orderby']
                                        : $available_options['basic']['archive_orderby']['default'],
                'group_comics'    => $this->_sanitize_integer($options, 'basic', 'group_comics'),
                'group_by_parent' => $this->_sanitize_integer($options, 'basic', 'group_by_parent'),
            );

            if ($options['basic']['latestcomic_page'] !== 'no_val'){
                $new_options['basic']['latestcomic_page'] = $options['basic']['latestcomic_page'];
            } else {
                $new_options['basic']['latestcomic_page'] = 0;
            }

            if ($options['basic']['comicarchive_page'] !== 'no_val') {
                $new_options['basic']['comicarchive_page'] = $options['basic']['comicarchive_page'];
            } else {
                $new_options['basic']['comicarchive_page'] = 0;
            }

            if ($options['basic']['comicarchive_page_style'] !== 'no_val') {
                 $new_options['basic']['comicarchive_page_style'] = $options['basic']['comicarchive_page_style'];
            } else {
                 $new_options['basic']['comicarchive_page_style'] = 'list';
            }

            flush_rewrite_rules(false);
        }

        if ($section == 'comic_page') {
            $new_options['comic_page'] = array(
                'generate_comic_page' => $this->_sanitize_integer($options, 'comic_page','generate_comic_page'),
                'comic_page_width'    => $this->_sanitize_integer($options, 'comic_page','comic_page_width'),
                'comic_page_height'   => $this->_sanitize_integer($options, 'comic_page','comic_page_height'),
            );
        }

        return array_merge($mp_options, $new_options);
    }


    /**
     * Sanitize integers
     *
     * @param array $option_array
     * @param string $section
     * @param string $name
     *
     * @return mixed
     */
    private function _sanitize_integer($option_array, $section, $name)
    {
        return isset($option_array[$section][$name])
                ? intval($option_array[$section][$name]) : 0;
    }
}
