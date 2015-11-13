<?php

namespace yii\authclient\clients;

use yii\authclient\OAuth2;

class SPiDOAuth extends OAuth2 {

    public $authUrl;

    public $tokenUrl = '';

    public $apiBaseUrl = '';
    
    public $identity_domain = '';

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (empty($this->identity_domain)) {
            $this->identity_domain = defined('YII_ENV') && constant('YII_ENV') == 'dev' ? 'identity-pre.schibsted.com' : 'login.schibsted.com';
        }
        
        $this->authUrl = empty($this->authUrl) ? 'https://'.$this->identity_domain.'/flow/auth' : $this->authUrl;
        $this->tokenUrl = empty($this->tokenUrl) ? 'https://'.$this->identity_domain.'/oauth/token' : $this->tokenUrl;
        $this->apiBaseUrl = empty($this->apiBaseUrl) ? 'https://'.$this->identity_domain.'/api/2/' : $this->apiBaseUrl;
        parent::init();
    }

    /**
     * @inheritdoc
     */
    protected function defaultName()
    {
        return 'spid';
    }

    /**
     * @inheritdoc
     */
    protected function defaultTitle()
    {
        return 'SPiD';
    }

    /**
     * @inheritdoc
     */
    protected function initUserAttributes()
    {
        $user = $this->api('me', 'GET', ['oauth_token' => $this->getAccessToken()->getToken()]);
        return $user['data'];
    }


}
