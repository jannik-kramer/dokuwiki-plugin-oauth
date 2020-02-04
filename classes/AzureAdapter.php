<?php

namespace OAuth\Plugin;


class AzureAdapter extends AbstractAdapter {

    /**
     * Retrieve the user's data
     *
     * The array needs to contain at least 'user', 'mail', 'name' and optional 'grps'
     *
     * @return array
     */
    public function getUser() {
        $JSON = new \JSON(JSON_LOOSE_TYPE);
        $data = array();

        /** var OAuth\OAuth2\Service\Generic $this->oAuth */
        $result = $JSON->decode($this->oAuth->request('https://graph.microsoft.com/v1.0/me/'));

        $data['user'] = strtolower(str_replace(' ', '.', $result['displayName']));
        $data['name'] = $result['displayName'];
        $data['mail'] = $result['mail'];

        return $data;
    }

    /**
     * We make use of the "Generic" oAuth 2 Service as defined in
     * phpoauthlib/src/OAuth/OAuth2/Service/Generic.php
     *
     * @return string
     */
    public function getServiceName() {
        return 'azure';
    }

    public function getScope()
    {
        return array('openid', 'profile');
    }
}