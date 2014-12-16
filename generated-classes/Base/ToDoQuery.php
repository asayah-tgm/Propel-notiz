<?php

namespace Base;

use \ToDo as ChildToDo;
use \ToDoQuery as ChildToDoQuery;
use \Exception;
use Map\ToDoTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'toDo' table.
 *
 *
 *
 * @method     ChildToDoQuery orderByTodoId($order = Criteria::ASC) Order by the toDo_id column
 * @method     ChildToDoQuery orderByStatus($order = Criteria::ASC) Order by the status column
 * @method     ChildToDoQuery orderByPriority($order = Criteria::ASC) Order by the priority column
 *
 * @method     ChildToDoQuery groupByTodoId() Group by the toDo_id column
 * @method     ChildToDoQuery groupByStatus() Group by the status column
 * @method     ChildToDoQuery groupByPriority() Group by the priority column
 *
 * @method     ChildToDoQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildToDoQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildToDoQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildToDoQuery leftJoinNotiz($relationAlias = null) Adds a LEFT JOIN clause to the query using the Notiz relation
 * @method     ChildToDoQuery rightJoinNotiz($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Notiz relation
 * @method     ChildToDoQuery innerJoinNotiz($relationAlias = null) Adds a INNER JOIN clause to the query using the Notiz relation
 *
 * @method     \NotizQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildToDo findOne(ConnectionInterface $con = null) Return the first ChildToDo matching the query
 * @method     ChildToDo findOneOrCreate(ConnectionInterface $con = null) Return the first ChildToDo matching the query, or a new ChildToDo object populated from the query conditions when no match is found
 *
 * @method     ChildToDo findOneByTodoId(int $toDo_id) Return the first ChildToDo filtered by the toDo_id column
 * @method     ChildToDo findOneByStatus(string $status) Return the first ChildToDo filtered by the status column
 * @method     ChildToDo findOneByPriority(int $priority) Return the first ChildToDo filtered by the priority column
 *
 * @method     ChildToDo[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildToDo objects based on current ModelCriteria
 * @method     ChildToDo[]|ObjectCollection findByTodoId(int $toDo_id) Return ChildToDo objects filtered by the toDo_id column
 * @method     ChildToDo[]|ObjectCollection findByStatus(string $status) Return ChildToDo objects filtered by the status column
 * @method     ChildToDo[]|ObjectCollection findByPriority(int $priority) Return ChildToDo objects filtered by the priority column
 * @method     ChildToDo[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ToDoQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Base\ToDoQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'notizen', $modelName = '\\ToDo', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildToDoQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildToDoQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildToDoQuery) {
            return $criteria;
        }
        $query = new ChildToDoQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildToDo|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        throw new LogicException('The ToDo object has no primary key');
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        throw new LogicException('The ToDo object has no primary key');
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildToDoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        throw new LogicException('The ToDo object has no primary key');
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildToDoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        throw new LogicException('The ToDo object has no primary key');
    }

    /**
     * Filter the query on the toDo_id column
     *
     * Example usage:
     * <code>
     * $query->filterByTodoId(1234); // WHERE toDo_id = 1234
     * $query->filterByTodoId(array(12, 34)); // WHERE toDo_id IN (12, 34)
     * $query->filterByTodoId(array('min' => 12)); // WHERE toDo_id > 12
     * </code>
     *
     * @see       filterByNotiz()
     *
     * @param     mixed $todoId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildToDoQuery The current query, for fluid interface
     */
    public function filterByTodoId($todoId = null, $comparison = null)
    {
        if (is_array($todoId)) {
            $useMinMax = false;
            if (isset($todoId['min'])) {
                $this->addUsingAlias(ToDoTableMap::COL_TODO_ID, $todoId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($todoId['max'])) {
                $this->addUsingAlias(ToDoTableMap::COL_TODO_ID, $todoId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ToDoTableMap::COL_TODO_ID, $todoId, $comparison);
    }

    /**
     * Filter the query on the status column
     *
     * Example usage:
     * <code>
     * $query->filterByStatus('fooValue');   // WHERE status = 'fooValue'
     * $query->filterByStatus('%fooValue%'); // WHERE status LIKE '%fooValue%'
     * </code>
     *
     * @param     string $status The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildToDoQuery The current query, for fluid interface
     */
    public function filterByStatus($status = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($status)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $status)) {
                $status = str_replace('*', '%', $status);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ToDoTableMap::COL_STATUS, $status, $comparison);
    }

    /**
     * Filter the query on the priority column
     *
     * Example usage:
     * <code>
     * $query->filterByPriority(1234); // WHERE priority = 1234
     * $query->filterByPriority(array(12, 34)); // WHERE priority IN (12, 34)
     * $query->filterByPriority(array('min' => 12)); // WHERE priority > 12
     * </code>
     *
     * @param     mixed $priority The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildToDoQuery The current query, for fluid interface
     */
    public function filterByPriority($priority = null, $comparison = null)
    {
        if (is_array($priority)) {
            $useMinMax = false;
            if (isset($priority['min'])) {
                $this->addUsingAlias(ToDoTableMap::COL_PRIORITY, $priority['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($priority['max'])) {
                $this->addUsingAlias(ToDoTableMap::COL_PRIORITY, $priority['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ToDoTableMap::COL_PRIORITY, $priority, $comparison);
    }

    /**
     * Filter the query by a related \Notiz object
     *
     * @param \Notiz|ObjectCollection $notiz The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildToDoQuery The current query, for fluid interface
     */
    public function filterByNotiz($notiz, $comparison = null)
    {
        if ($notiz instanceof \Notiz) {
            return $this
                ->addUsingAlias(ToDoTableMap::COL_TODO_ID, $notiz->getNotizId(), $comparison);
        } elseif ($notiz instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ToDoTableMap::COL_TODO_ID, $notiz->toKeyValue('PrimaryKey', 'NotizId'), $comparison);
        } else {
            throw new PropelException('filterByNotiz() only accepts arguments of type \Notiz or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Notiz relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildToDoQuery The current query, for fluid interface
     */
    public function joinNotiz($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Notiz');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Notiz');
        }

        return $this;
    }

    /**
     * Use the Notiz relation Notiz object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \NotizQuery A secondary query class using the current class as primary query
     */
    public function useNotizQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinNotiz($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Notiz', '\NotizQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildToDo $toDo Object to remove from the list of results
     *
     * @return $this|ChildToDoQuery The current query, for fluid interface
     */
    public function prune($toDo = null)
    {
        if ($toDo) {
            throw new LogicException('ToDo object has no primary key');

        }

        return $this;
    }

    /**
     * Deletes all rows from the toDo table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ToDoTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ToDoTableMap::clearInstancePool();
            ToDoTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ToDoTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ToDoTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ToDoTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ToDoTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ToDoQuery
