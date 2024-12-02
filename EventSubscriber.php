<?php
namespace Drupal\ygrene_helper\EventSubscriber;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use \Drupal\Core\Routing\TrustedRedirectResponse;
use Drupal\Core\Url;
use Drupal\Component\Utility\UrlHelper;
use Drupal\Core\Cache\CacheableMetadata;

class EventSubscriber implements EventSubscriberInterface {

  public function redirect(RequestEvent $event) {
    $req_host = $event->getRequest()->getHost();
    $req_scheme = $event->getRequest()->getScheme();
    $req_url = $event->getRequest()->getSchemeAndHttpHost();
    print $req_host;print "</br>";print $req_scheme;print "</br>";print $req_url;
    $new_host = 'www.' . $req_host;
    print $new_host;
    $new_url = "https" . '://' . $new_host;
    print $new_url;
   if (UrlHelper::isValid($new_url, TRUE) && $req_url !== $new_url){
      $new_url .= $event->getRequest()->getRequestUri();
      $response = new TrustedRedirectResponse($new_url, 301);
      $build = [
        '#cache' => [
          'max-age'  => 0,
          'contexts' => ['url', 'user.permissions'],
          'tags'     => ['testing'],
        ],
      ];
      $cache_meta = CacheableMetadata::createFromRenderArray($build);
      $response->addCacheableDependency($cache_meta);

      $event->setResponse($response);
    }
  }

  public function onRedirect(RequestEvent $event) {
    $req_host = $event->getRequest()->getHost();
    $req_scheme = $event->getRequest()->getScheme();
    $req_url = $event->getRequest()->getSchemeAndHttpHost();
    print $req_host;print "</br>";print $req_scheme;print "</br>";print $req_url;
    $new_host = 'www.' . $req_host;
    print $new_host;
    $new_url = "https" . '://' . $new_host;
    print $new_url;
    if (UrlHelper::isValid($new_url, TRUE) && $req_url !== $new_url)
      $new_url .= $event->getRequest()->getRequestUri();
      $response = new TrustedRedirectResponse($new_url, 301);

  	$current_uri = \Drupal::request()->getRequestUri();
  	$path = explode('/',$current_uri);
    if($current_uri == "/get-approved") {
      $response = new TrustedRedirectResponse(Url::fromUri('https://prequalification.ygrene.com/prequal')->toString());
      $event->setResponse($response);
    }
    if($current_uri == "/even") {
      $response = new TrustedRedirectResponse(Url::fromUri('https://prequalification.ygrene.com/prequal')->toString());
      $event->setResponse($response);
    }
    if($current_uri == "/optout") {
      $response = new TrustedRedirectResponse(Url::fromUri('https://cloud.e.ygrene.com/opt-out')->toString());
      $event->setResponse($response);
    }
    if($path[1] == "es" && $path[2] == "get-approved") {
      $response = new TrustedRedirectResponse(Url::fromUri('https://prequalification.ygrene.com/prequal?language=esp')->toString());
      $event->setResponse($response);
    }
    if($current_uri == "/ohio") {
      $response = new RedirectResponse("/home");
      $event->setResponse($response);
    }
    /*if($current_uri == "/" || $current_uri == "/find-contractors" || $path[1] == "blog") {
      $response = new RedirectResponse("/home-improvement-loans");
      $event->setResponse($response);
    }*/

    /*if(!($current_uri == "/our-story" || $current_uri == "/contact-us" || $current_uri == "/our-story" || $current_uri == "/home-improvement-loans" || $path[1] == "admin" || $path[1] == "user" || $current_uri == "/user" || $current_uri == "/login" || $current_uri == "/privacy-policy" || $current_uri == "/terms-of-use" || $current_uri == "/sitemap"  || $current_uri == "/fiona-legal" || ($path[1] == "node" && $path[3] == "edit") || $current_uri == "/privacy-policy-california" || $path[1] == "block")) {
      $response = new RedirectResponse("/home-improvement-loans");
      $event->setResponse($response);
    }*/
  }

  public function onKernelException(RequestEvent $event) {
    /*$current_uri = \Drupal::request()->getRequestUri();
    $path = explode('/',$current_uri);
    if($path[1] == "loans") {
      $response = new TrustedRedirectResponse(\Drupal\Core\Url::fromUri('https://cloud.e.ygrene.com/fiona?companyid='.$path[2])->toString());
      $event->setResponse($response);
    }*/
 }

      
  /**
  * {@inheritdoc}
  */
  public static function getSubscribedEvents() {
  	 $events[KernelEvents::REQUEST][] = ['onRedirect'];
     $events[KernelEvents::EXCEPTION][] = ['onKernelException'];
     $events[KernelEvents::REQUEST][] = ['redirect', 299];
    return $events;
  }
}