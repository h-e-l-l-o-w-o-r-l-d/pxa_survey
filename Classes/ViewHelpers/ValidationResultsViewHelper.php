<?php

namespace Pixelant\PxaSurvey\ViewHelpers;

use TYPO3\CMS\Extbase\Error\Result;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * Class ValidationResultsViewHelper
 * @package Pixelant\PxaSurvey\ViewHelpers
 */
class ValidationResultsViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    /**
     * @var Result
     */
    protected static $validationResults = null;

    /**
     * Initialize arguments
     *
     * @api
     */
    public function initializeArguments()
    {
        // @codingStandardsIgnoreStart
        $this->registerArgument('for', 'string', 'The name of the error name (e.g. argument name or property name). This can also be a property path (like blog.title), and will then only display the validation errors of that property.', true);
        // @codingStandardsIgnoreEnd
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return Result
     */
    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) {
        $for = $arguments['for'];
        $validationResults = self::getValidationResults($renderingContext);

        if ($validationResults !== null) {
            $validationResults = $validationResults->forProperty($for);
        }

        return $validationResults;
    }

    /**
     * Return validation results
     *
     * @param RenderingContextInterface $renderingContext
     * @return Result|null
     */
    protected static function getValidationResults(RenderingContextInterface $renderingContext)
    {
        if (self::$validationResults === null) {
            /** @noinspection PhpUndefinedMethodInspection */
            /** @var Result $validationResults */
            self::$validationResults = $renderingContext
                ->getControllerContext()
                ->getRequest()
                ->getOriginalRequestMappingResults();
        }

        return self::$validationResults;
    }
}
