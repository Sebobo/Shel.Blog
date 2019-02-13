<?php

namespace Shel\Blog\Fusion\FlowQueryOperations;

/*                                                                        *
 * This script belongs to the Flow package "Shel.Blog".                   *
 *                                                                        *
 * @author Sebastian Helzle <sebastian@helzle.it>                         *
 *                                                                        */

use Neos\Eel\FlowQuery\FlowQueryException;
use Neos\Eel\FlowQuery\Operations\AbstractOperation;
use Neos\Flow\Annotations as Flow;
use Neos\ContentRepository\Domain\Model\NodeInterface;
use Neos\Eel\FlowQuery\FlowQuery;
use Neos\ContentRepository\Domain\Model\Node;

/**
 * EEL sort() operation to sort Nodes.
 *
 * Use it like this:
 *
 *    ${q(node).children().sortBlogEntries('publicationDate', 'DESC')}
 */
class SortBlogEntriesOperation extends AbstractOperation
{
    /**
     * {@inheritdoc}
     *
     * @var string
     */
    protected static $shortName = 'sortBlogEntries';

    /**
     * {@inheritdoc}
     *
     * @var int
     */
    protected static $priority = 100;

    /**
     * {@inheritdoc}
     *
     * We can only handle NeosCR Nodes.
     *
     * @param mixed $context
     *
     * @return bool
     */
    public function canEvaluate($context)
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
            throw new FlowQueryException('sort() needs property name by which nodes should be sorted', 1332492263);
        } else {
            $nodes = $flowQuery->getContext();
            $sortByPropertyPath = $arguments[0];
            $sortOrder = 'ASC';
            if (isset($arguments[1]) && !empty($arguments[1]) && in_array($arguments[1], array('ASC', 'DESC'))) {
                $sortOrder = $arguments[1];
            }
            $sortedNodes = array();
            $sortSequence = array();
            $nodesByIdentifier = array();
            /** @var Node $node  */
            foreach ($nodes as $node) {
                $propertyValue = $node->getProperty($sortByPropertyPath);
                if ($propertyValue instanceof \DateTime) {
                    $propertyValue = $propertyValue->getTimestamp();
                }
                $sortSequence[$node->getIdentifier()] = $propertyValue;
                $nodesByIdentifier[$node->getIdentifier()] = $node;
            }
            if ($sortOrder === 'DESC') {
                arsort($sortSequence);
            } else {
                asort($sortSequence);
            }
            foreach ($sortSequence as $nodeIdentifier => $value) {
                $sortedNodes[] = $nodesByIdentifier[$nodeIdentifier];
            }
            $flowQuery->setContext($sortedNodes);
        }
    }
}
