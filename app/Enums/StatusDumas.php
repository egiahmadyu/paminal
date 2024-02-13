<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class StatusDumas extends Enum
{
    const Diterima = 1;
    const LimpahPolda = 3;
    const Pulbaket = 4;
    const GelarPerkara = 5;
    const LimpahBiro = 6;
    const RestorativeJustice = 7;
    const SelesaiTidakBenar = 8;
    const DiprosesPolda = 9;
}
