<?php

/*
 * This file is part of the Orient package.
 *
 * (c) Alessandro Nadalin <alessandro.nadalin@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Class Graph is a dataset to easily work with a simulated graph.
 *
 * @package     Orient
 * @subpackage  Graph
 * @author      Alessandro Nadalin <alessandro.nadalin@gmail.com>
 */

//namespace Doctrine\OrientDB\Graph;

//use Doctrine/OrientDB/Exception;

class Graph
{
    /**
     * All the vertices in the graph
     *
     * @var array
     */
    protected $vertices = array();


    public function add(Vertex $vertex)
    {
        if (array_key_exists($vertex->getId(), $this->getVertices())) {
            //throw new Exception
		echo ('EXCEPTION line 38 in Graph.php: Unable to insert multiple Vertices with the same ID in a Graph');
        } else

        $this->vertices[$vertex->getId()] = $vertex;

        return $this;
    }


    public function getVertex($id)
    {
        $vertices = $this->getVertices();

        if (!array_key_exists($id, $vertices)) {
            //throw new Exception
		echo ("<b>EXCEPTION line 53 in Grap.php</b>: Unable to find $id in the Graph");
        } else

        return $vertices[$id];
    }

    public function getVertices()
    {
        return $this->vertices;
    }
}

?>
