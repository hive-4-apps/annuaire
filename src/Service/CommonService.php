<?php

	namespace App\Service;

	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

	class CommonService {

		private $router;
		public function __construct( UrlGeneratorInterface $router ) {
			$this->router = $router;
		}

		public function getFrenchUrl( Request $request ){
			return $this->getLanguageUrl($request, 'fr' );
		}

		public function getBrazilianUrl( Request $request ){
			return $this->getLanguageUrl($request, 'br' );
		}

		private function getLanguageUrl( Request $request, string $lang ){
			$attributes = $request->attributes->all();
			$parameters = $request->request->all();
			foreach ( $attributes as $key_attribute => $attribute ){
				if( !str_starts_with( $key_attribute, '_') ){
					$parameters[$key_attribute] = $attribute;
				}
			}
			$parameters['lang'] = $lang;
			return $this->router->generate($request->get('_route'), $parameters, UrlGeneratorInterface::ABSOLUTE_URL );
		}
	}
