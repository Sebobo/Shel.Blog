<?php

namespace Shel\Blog\Fusion\FlowQueryOperations;

/*                                                                        *
 * This script belongs to the Flow package "Shel.Blog".                   *
 *                                                                        *
 * @author Sebastian Helzle <sebastian@helzle.it>                         *
 *                                                                        */

use Neos\Eel\FlowQuery\FlowQueryException;
use Neos\Eel\FlowQuery\Operations\AbstractOperation;
use Neos\ContentRepository\Domain\Model\NodeInterface;
use Neos\Eel\FlowQuery\FlowQuery;

/**
 * EEL filterByReference() operation to filter nodes by a reference, like categories.
 *
 * Use it like this:
 *
 *    ${q(node).children().filterByReference(myCategoryNode, 'myCategoryReferencesField')}
 */
class FilterByReferenceOperation extends AbstractOperation
{
    /**
     * {@inheritdoc}
     *
     * @var string
     */
    protected static $shortName = 'filterByReference';

    /**
     * {@inheritdoc}
     *
     * @var int
     */
    protected static $priority = 90;

    /**
     * {@inheritdoc}
     *
     * We can only handle NeosCR Nodes.
     *
     * @param mixed $context
     *
     * @return bool
     */
    public function canEvaluate($context): bool
    {
        return (isset($context[0]) && ($context[0] instanceof NodeInterface));
    }

    /**
     * {@inheritdoc}
     *
     * @param FlowQuery $flowQuery the FlowQuery object
     * @param array $arguments the arguments for this operation
     *
     * @return void
     * @throws FlowQueryException
     */
    public function evaluate(FlowQuery $flowQuery, array $arguments)
    {
        if (!isset($arguments[0]) || empty($arguments[0])) {
            throw new FlowQueryException('filterByReference() needs a node by which the context should be filtered',
                1550053698);
        } elseif (!isset($arguments[1]) || empty($arguments[1])) {
            throw new FlowQueryException('filterByReference() needs a property name by which the context should be filtered',
                1550054406);
        } else {
            $nodes = $flowQuery->getContext();
            /** @var NodeInterface $category */
            $category = $arguments[0];
            $propertyName = $arguments[1];

            $filteredNodes = array_values(array_filter($nodes,
                function (NodeInterface $node) use ($category, $propertyName) {
                    $references = $node->getProperty($propertyName);
                    return is_array($references) && in_array($category, $references);
                }
            ));

            $flowQuery->setContext($filteredNodes);
        }
    }
}
