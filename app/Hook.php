<?php declare(strict_types=1);

namespace Portfolio;

final class Hook
{
    public function registerAssets(): self
    {
        add_action('wp_enqueue_scripts', function () {
            wp_enqueue_style('p-style', Helper::getDirUri('style.css'), [], Helper::fileVersion('style.css'));
            wp_enqueue_style('fa-style', Helper::getDirUri('assets/font-awesome/css/fontawesome.min.css'));
            wp_register_script('p-js', Helper::getDirUri('assets/main.js'), [], Helper::fileVersion('assets/main.js'), true);

            wp_localize_script('p-js', 'portfolio_globals', [
                'ajax_url' => admin_url('admin-ajax.php'),
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