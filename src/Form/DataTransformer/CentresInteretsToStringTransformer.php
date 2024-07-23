<?php

	namespace App\Form\DataTransformer;

	use App\Entity\CentreInteret;

	class CentresInteretsToStringTransformer extends DonneesToStringTransfromer {
		protected string $entityName = CentreInteret::class;
	}
