<?php
namespace Shel\Blog\Fusion\Helper;

/*                                                                        *
 * This script belongs to the Neos CMS plugin "Shel.Blog".                *
 *                                                                        *
 * @author Sebastian Helzle <sebastian@helzle.it>                         *
 *                                                                        */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\I18n\Formatter\DatetimeFormatter;
use Neos\Flow\I18n\Service as I18nService;
use Neos\Eel\ProtectedContextAwareInterface;

class FormatHelper implements ProtectedContextAwareInterface
{
    /**
     * @Flow\Inject
     * @var DatetimeFormatter
     */
    protected $datetimeFormatter;

    /**
     * @Flow\Inject
     * @var I18nService
     */
    protected $localizationService;

    /**
     * Render the supplied DateTime object as a formatted date.
     *
     * @param mixed $date either a \DateTime object or a string that is accepted by \DateTime constructor
     * @param string $format Format String which is taken to format the Date/Time if none of the locale options are set.
     * @param string $localeFormatType Whether to format (according to locale set in $forceLocale) date, time or dateTime. Must be one of Neos\Flow\I18n\Cldr\Reader\DatesReader::FORMAT_TYPE_*'s constants.
     * @param string $localeFormatLength Format length if locale set in $forceLocale. Must be one of Neos\Flow\I18n\Cldr\Reader\DatesReader::FORMAT_LENGTH_*'s constants.
     * @param string $cldrFormat Format string in CLDR format (see http://cldr.unicode.org/translation/date-time)
     * @return string Formatted date
     * @api
     */
    public function date($date, $format, $localeFormatType, $localeFormatLength, $cldrFormat)
    {
        if (!$date instanceof \DateTimeInterface) {
            try {
                $date = new \DateTime($date);
            } catch (\Exception $exception) {
                return '';
            }
        }

        $useLocale = $this->localizationService->getConfiguration()->getCurrentLocale();
        if ($useLocale !== null) {
            if ($cldrFormat !== null) {
                $output = $this->datetimeFormatter->formatDateTimeWithCustomPattern($date, $cldrFormat, $useLocale);
            } else {
                $output = $this->datetimeFormatter->format($date, $useLocale, [$localeFormatType, $localeFormatLength]);
            }
        } else {
            $output = $date->format($format);
        }

        return $output;
    }

    /**
     * All methods are considered safe
     *
     * @param string $methodName
     * @return boolean
     */
    public function allowsCallOfMethod($methodName)
    {
        return true;
    }
}
