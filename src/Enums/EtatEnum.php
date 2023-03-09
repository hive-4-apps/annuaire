<?php

	namespace App\Enums;

	enum EtatEnum : int {
		case EN_ATTENTE = 1;
		case APPROUVE = 2;
		case SUPPRIME = 3;
	}
