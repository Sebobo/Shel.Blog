<?php
namespace Shel\Blog\Fusion\Helper;

/*                                                                        *
 * This script belongs to the Neos CMS plugin "Shel.Blog".                *
 *                                                                        *
 * @author Sebastian Helzle <sebastian@helzle.it>                         *
 *                                                                        */

use Neos\ContentRepository\Domain\Model\NodeInterface;
use Neos\ContentRepository\Exception\NodeException;
use Neos\Eel\ProtectedContextAwareInterface;

class StructureHelper implements ProtectedContextAwareInterface
{

    /**
     * @param array<NodeInterface> $nodes
     * @param string $textProperty
     * @return array
     * @throws NodeException
     */
    public function createTableOfContents(array $nodes, $textProperty = 'title'): array
    {
        $items = [];

        /** @var NodeInterface $node */
        foreach ($nodes as $node) {
            $text = $node->getProperty($textProperty);
            preg_match_all('/<h(\d)>(.+)<\/.*/mi', $text, $parts);

            $level = $parts[1];
            $label = $parts[2];

            if (!empty($level) && !empty($label)) {
                $items[]= [
                    'node' => $node,
                    'level'=> intval($level[0]),
                    'label' => $label[0],
                    'items' => [],
                ];
            }
        }

        return $this->restructureLevel($items);
    }

    /**
     * @param array $items
     * @return array
     */
    protected function restructureLevel(array $items): array
    {
        $lastItem = 0;
        $itemCount = count($items);
        $i = 0;
        while (++$i < $itemCount) {
            $currentItem = $items[$i];

            if ($currentItem['level'] > $items[$lastItem]['level']) {
                $items[$lastItem]['items'][]= $currentItem;
                unset($items[$i]);
            } else {
                if (count($items[$lastItem]['items'])) {
                    $items[$lastItem]['items'] = $this->restructureLevel($items[$lastItem]['items']);
                }
                $lastItem = $i;
            }
        }
        return array_values($items);
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
