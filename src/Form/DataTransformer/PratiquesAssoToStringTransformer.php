<?php

	namespace App\Form\DataTransformer;

	use App\Entity\PratiqueAsso;

	class PratiquesAssoToStringTransformer extends DonneesToStringTransfromer {
		protected string $entityName = PratiqueAsso::class;
	}
