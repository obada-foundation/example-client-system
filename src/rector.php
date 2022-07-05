<?php

declare(strict_types=1);

use Rector\Core\Configuration\Option;
use Rector\Php71\Rector\ClassConst\PublicConstantVisibilityRector;
use Rector\Php70\Rector\Ternary\TernaryToNullCoalescingRector;
use Rector\Php53\Rector\Ternary\TernaryToElvisRector;
use Rector\Php56\Rector\FuncCall\PowToExpRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\PostRector\Rector\NameImportingPostRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Rector\CodeQuality\Rector\If_\SimplifyIfReturnBoolRector;
use Rector\CodeQuality\Rector\If_\CombineIfRector;
use Rector\CodingStyle\Rector\FuncCall\ConsistentImplodeRector;
use Rector\CodeQuality\Rector\FunctionLike\SimplifyUselessVariableRector;
use Rector\DeadCode\Rector\Switch_\RemoveDuplicatedCaseInSwitchRector;
use Rector\DeadCode\Rector\Stmt\RemoveUnreachableStatementRector;
use Rector\DeadCode\Rector\Foreach_\RemoveUnusedForeachKeyRector;
use Rector\DeadCode\Rector\If_\SimplifyIfElseWithSameContentRector;
use Rector\DeadCode\Rector\Cast\RecastingRemovalRector;
use Rector\DeadCode\Rector\Assign\RemoveUnusedVariableAssignRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedConstructorParamRector;
use Rector\DeadCode\Rector\Array_\RemoveDuplicatedArrayKeyRector;
use Rector\DeadCode\Rector\Ternary\TernaryToBooleanOrFalseToBooleanAndRector;
use Rector\DeadCode\Rector\FunctionLike\RemoveOverriddenValuesRector;
use Rector\CodeQuality\Rector\Ternary\UnnecessaryTernaryExpressionRector;
use Rector\Php71\Rector\FuncCall\RemoveExtraParametersRector;

return static function (ContainerConfigurator $containerConfigurator): void {
    // get parameters
    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PATHS, [
        __DIR__ . '/app',
        __DIR__ . '/tests',
        __DIR__ . '/config',
        __DIR__ . '/routes',
        __DIR__ . '/database',
    ]);

    // Define what rule sets will be applied
    $containerConfigurator->import(LevelSetList::UP_TO_PHP_81);

    // get services (needed for register a single rule)
    $services = $containerConfigurator->services();

    //register a single rule
    $services->set(PublicConstantVisibilityRector::class);
    $services->set(TernaryToNullCoalescingRector::class);
    $services->set(TernaryToElvisRector::class);
    $services->set(PowToExpRector::class);
    $services->set(NameImportingPostRector::class);
    $services->set(SimplifyIfReturnBoolRector::class);
    $services->set(CombineIfRector::class);
    $services->set(ConsistentImplodeRector::class);
    $services->set(SimplifyUselessVariableRector::class);
    $services->set(RemoveDuplicatedCaseInSwitchRector::class);
    $services->set(RemoveUnreachableStatementRector::class);
    $services->set(RemoveUnusedForeachKeyRector::class);
    $services->set(SimplifyIfElseWithSameContentRector::class);
    $services->set(RecastingRemovalRector::class);
    $services->set(RemoveUnusedVariableAssignRector::class);
    $services->set(RemoveUnusedConstructorParamRector::class);
    $services->set(RemoveDuplicatedArrayKeyRector::class);
    $services->set(TernaryToBooleanOrFalseToBooleanAndRector::class);
    $services->set(RemoveOverriddenValuesRector::class);
    $services->set(UnnecessaryTernaryExpressionRector::class);
    $services->set(RemoveExtraParametersRector::class);
};
