<?php

	namespace App\Form\DataTransformer;

	use App\Entity\Connaissance;

	class ConnaissancesToStringTransformer extends DonneesToStringTransfromer {
		protected string $entityName = Connaissance::class;
	}
