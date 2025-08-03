<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use App\Models\LanguageModel;
use App\Controllers\Login;
use Config\Services;

class Auth implements FilterInterface
{
    /**
     * Process before the request is executed.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return RequestInterface|ResponseInterface|string|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {

        $session = session();
        $userID = $session->get('inv_userid');
        $currentSessionId = $session->get('current_session_id');

        if (!$userID) {
            return redirect()->to(base_url('login'))->with('msg', 'Please log in first.');
        }

        $model = new UserModel();
        $user = $model->find($userID);

        if (!$user) {
            $session->destroy();
            return redirect()->to(base_url('login'))->with('msg', 'Invalid session.');
        }

        // Check if session_id matches
        if (!empty($user['session_id']) && $user['session_id'] !== $currentSessionId) {
            $session->destroy();
            return redirect()->to(base_url('login'))->with('msg', 'Session mismatch.');
        }

        // Session timeout: 15 minutes (900 seconds)
        // $lastActivity = $user['lastActivity'] ?? null;
        // if ($lastActivity && (time() - strtotime($lastActivity)) > 900) {
        //     $session->destroy();
        //     return redirect()->to(base_url('login'))->with('msg', 'Session expired due to inactivity (15 minutes).');
        // }

        // // Update last activity timestamp
        // $model->update($user['id'], ['lastActivity' => date('Y-m-d H:i:s')]);

        // No redirect — allow access

        // Set language from user preference
        if ($session->has('logged_in') && !$session->has('language')) {
            $user = $session->get('user'); // adjust to your session structure

            if (!empty($user['language_id'])) {
                $languageModel = new LanguageModel();
                $language = $languageModel->find($user['language_id']);

                if ($language && isset($language['name'])) {
                    $session->set('language', $language['name']);
                }
            }
        }

        // Apply language to current request
        $locale = $session->get('language') ?? 'English';
        Services::language()->setLocale($locale);
        $request->setLocale($locale); // This makes `$this->request->getLocale()` return the right value
        $data['language'] = $locale;
        $request->setGlobal('post', $data);
    }

    /**
     * Process after the request is executed.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return ResponseInterface|void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // You can implement any post-processing here, if necessary
    }
}
