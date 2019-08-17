<?php declare(strict_types=1);

namespace Portfolio;

final class Hook
{
    public function addNewImageSize(): self
    {
        add_image_size('normal', 600, 400, true);
        return $this;
    }

    public function addThumbFieldToJsonObject(): self
    {
        add_filter('rest_prepare_post', function ($data, $post) {
            $thumb_id = get_post_thumbnail_id($post->ID);
            $data->data['image'] = wp_get_attachment_image_src($thumb_id, 'normal')[0];
            $data->data['fullImage'] = wp_get_attachment_image_src($thumb_id, 'large')[0];

            return $data;
        }, 10, 3);

        return $this;
    }

    public function registerAssets(): self
    {
        add_action('wp_enqueue_scripts', function () {
            wp_enqueue_style('p-style', Helper::getDirUri('style.css'), [], Helper::fileVersion('style.css'));
            wp_enqueue_style('fa-style', Helper::getDirUri('assets/font-awesome/css/fontawesome.min.css'));
            wp_register_script('p-js', Helper::getDirUri('assets/main.js'), [], Helper::fileVersion('assets/main.js'), true);

            wp_localize_script('p-js', 'portfolio_globals', [
                'ajax' => admin_url('admin-ajax.php'),
                'api' => home_url('?rest_route=/wp/v2/'),
                'nonce' => wp_create_nonce('portfolio'),
            ]);

            wp_deregister_script('jquery');
            wp_enqueue_script('p-js');
        });

        return $this;
    }

    public function addAfterThemeSupport(): self
    {
        add_action('after_setup_theme', function (): void {
            add_theme_support('post-thumbnails');
        });
        return $this;
    }

    public function disableWordpressStuff(): self
    {
        WordpressDisabler::enable();
        return $this;
    }
}