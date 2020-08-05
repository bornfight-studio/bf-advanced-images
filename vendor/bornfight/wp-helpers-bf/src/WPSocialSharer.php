<?php
namespace bornfight\wpHelpers;

class WPSocialSharer extends SocialSharer
{
    public function get_fb_share_link($url = null)
    {
        if ($url === null) {
            $url = get_permalink();
        }
        return parent::get_fb_share_link($url);
    }

    public function get_twitter_share_link($url = null)
    {
        if ($url === null) {
            $url = get_permalink();
        }
        return parent::get_twitter_share_link($url);
    }

    public function get_linkedin_share_link($url = null)
    {
        if ($url === null) {
            $url = get_permalink();
        }
        return parent::get_linkedin_share_link($url);
    }

    public function get_email_share_link($url = null)
    {
        if ($url === null) {
            $url = get_permalink();
        }
        return parent::get_email_share_link($url);
    }

    public function get_fb_share_count($url = null)
    {
        if ($url === null) {
            $url = get_permalink();
        }
        return parent::get_fb_share_count($url);
    }

    public function get_twitter_share_count($url = null)
    {
        if ($url === null) {
            $url = get_permalink();
        }
        return parent::get_twitter_share_count($url);
    }

    public function get_linkedin_share_count($url = null)
    {
        if ($url === null) {
            $url = get_permalink();
        }
        return parent::get_linkedin_share_count($url);
    }
}
