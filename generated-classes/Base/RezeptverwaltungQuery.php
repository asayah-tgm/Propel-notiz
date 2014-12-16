<?php

namespace Base;

use \Rezeptverwaltung as ChildRezeptverwaltung;
use \RezeptverwaltungQuery as ChildRezeptverwaltungQuery;
use \Exception;
use Map\RezeptverwaltungTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'rezeptverwaltung' table.
 *
 *
 *
 * @method     ChildRezeptverwaltungQuery orderByFkrezeptId($order = Criteria::ASC) Order by the fkrezept_id column
 * @method     ChildRezeptverwaltungQuery orderByFknotizId($order = Criteria::ASC) Order by the fknotiz_id column
 *
 * @method     ChildRezeptverwaltungQuery groupByFkrezeptId() Group by the fkrezept_id column
 * @method     ChildRezeptverwaltungQuery groupByFknotizId() Group by the fknotiz_id column
 *
 * @method     ChildRezeptverwaltungQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildRezeptverwaltungQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildRezeptverwaltungQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildRezeptverwaltungQuery leftJoinNotiz($relationAlias = null) Adds a LEFT JOIN clause to the query using the Notiz relation
 * @method     ChildRezeptverwaltungQuery rightJoinNotiz($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Notiz relation
 * @method     ChildRezeptverwaltungQuery innerJoinNotiz($relationAlias = null) Adds a INNER JOIN clause to the query using the Notiz relation
 *
 * @method     ChildRezeptverwaltungQuery leftJoinRezept($relationAlias = null) Adds a LEFT JOIN clause to the query using the Rezept relation
 * @method     ChildRezeptverwaltungQuery rightJoinRezept($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Rezept relation
 * @method     ChildRezeptverwaltungQuery innerJoinRezept($relationAlias = null) Adds a INNER JOIN clause to the query using the Rezept relation
 *
 * @method     \NotizQuery|\RezeptQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildRezeptverwaltung findOne(ConnectionInterface $con = null) Return the first ChildRezeptverwaltung matching the query
 * @method     ChildRezeptverwaltung findOneOrCreate(ConnectionInterface $con = null) Return the first ChildRezeptverwaltung matching the query, or a new ChildRezeptverwaltung object populated from the query conditions when no match is found
 *
 * @method     ChildRezeptverwaltung findOneByFkrezeptId(int $fkrezept_id) Return the first ChildRezeptverwaltung filtered by the fkrezept_id column
 * @method     ChildRezeptverwaltung findOneByFknotizId(int $fknotiz_id) Return the first ChildRezeptverwaltung filtered by the fknotiz_id column
 *
 * @method     ChildRezeptverwaltung[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildRezeptverwaltung objects based on current ModelCriteria
 * @method     ChildRezeptverwaltung[]|ObjectCollection findByFkrezeptId(int $fkrezept_id) Return ChildRezeptverwaltung objects filtered by the fkrezept_id column
 * @method     ChildRezeptverwaltung[]|ObjectCollection findByFknotizId(int $fknotiz_id) Return ChildRezeptverwaltung objects filtered by the fknotiz_id column
 * @method     ChildRezeptverwaltung[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class RezeptverwaltungQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Base\RezeptverwaltungQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'notizen', $modelName = '\\Rezeptverwaltung', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildRezeptverwaltungQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildRezeptverwaltungQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildRezeptverwaltungQuery) {
            return $criteria;
        }
        $query = new ChildRezeptverwaltungQuery();
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
     * @return ChildRezeptverwaltung|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        throw new LogicException('The Rezeptverwaltung object has no primary key');
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
        throw new LogicException('The Rezeptverwaltung object has no primary key');
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildRezeptverwaltungQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        throw new LogicException('The Rezeptverwaltung object has no primary key');
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildRezeptverwaltungQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        throw new LogicException('The Rezeptverwaltung object has no primary key');
    }

    /**
     * Filter the query on the fkrezept_id column
     *
     * Example usage:
     * <code>
     * $query->filterByFkrezeptId(1234); // WHERE fkrezept_id = 1234
     * $query->filterByFkrezeptId(array(12, 34)); // WHERE fkrezept_id IN (12, 34)
     * $query->filterByFkrezeptId(array('min' => 12)); // WHERE fkrezept_id > 12
     * </code>
     *
     * @see       filterByRezept()
     *
     * @param     mixed $fkrezeptId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRezeptverwaltungQuery The current query, for fluid interface
     */
    public function filterByFkrezeptId($fkrezeptId = null, $comparison = null)
    {
        if (is_array($fkrezeptId)) {
            $useMinMax = false;
            if (isset($fkrezeptId['min'])) {
                $this->addUsingAlias(RezeptverwaltungTableMap::COL_FKREZEPT_ID, $fkrezeptId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fkrezeptId['max'])) {
                $this->addUsingAlias(RezeptverwaltungTableMap::COL_FKREZEPT_ID, $fkrezeptId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RezeptverwaltungTableMap::COL_FKREZEPT_ID, $fkrezeptId, $comparison);
    }

    /**
     * Filter the query on the fknotiz_id column
     *
     * Example usage:
     * <code>
     * $query->filterByFknotizId(1234); // WHERE fknotiz_id = 1234
     * $query->filterByFknotizId(array(12, 34)); // WHERE fknotiz_id IN (12, 34)
     * $query->filterByFknotizId(array('min' => 12)); // WHERE fknotiz_id > 12
     * </code>
     *
     * @see       filterByNotiz()
     *
     * @param     mixed $fknotizId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRezeptverwaltungQuery The current query, for fluid interface
     */
    public function filterByFknotizId($fknotizId = null, $comparison = null)
    {
        if (is_array($fknotizId)) {
            $useMinMax = false;
            if (isset($fknotizId['min'])) {
                $this->addUsingAlias(RezeptverwaltungTableMap::COL_FKNOTIZ_ID, $fknotizId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fknotizId['max'])) {
                $this->addUsingAlias(RezeptverwaltungTableMap::COL_FKNOTIZ_ID, $fknotizId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RezeptverwaltungTableMap::COL_FKNOTIZ_ID, $fknotizId, $comparison);
    }

    /**
     * Filter the query by a related \Notiz object
     *
     * @param \Notiz|ObjectCollection $notiz The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRezeptverwaltungQuery The current query, for fluid interface
     */
    public function filterByNotiz($notiz, $comparison = null)
    {
        if ($notiz instanceof \Notiz) {
            return $this
                ->addUsingAlias(RezeptverwaltungTableMap::COL_FKNOTIZ_ID, $notiz->getNotizId(), $comparison);
        } elseif ($notiz instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RezeptverwaltungTableMap::COL_FKNOTIZ_ID, $notiz->toKeyValue('PrimaryKey', 'NotizId'), $comparison);
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
     * @return $this|ChildRezeptverwaltungQuery The current query, for fluid interface
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
     * Filter the query by a related \Rezept object
     *
     * @param \Rezept|ObjectCollection $rezept The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRezeptverwaltungQuery The current query, for fluid interface
     */
    public function filterByRezept($rezept, $comparison = null)
    {
        if ($rezept instanceof \Rezept) {
            return $this
                ->addUsingAlias(RezeptverwaltungTableMap::COL_FKREZEPT_ID, $rezept->getRezeptId(), $comparison);
        } elseif ($rezept instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RezeptverwaltungTableMap::COL_FKREZEPT_ID, $rezept->toKeyValue('PrimaryKey', 'RezeptId'), $comparison);
        } else {
            throw new PropelException('filterByRezept() only accepts arguments of type \Rezept or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Rezept relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRezeptverwaltungQuery The current query, for fluid interface
     */
    public function joinRezept($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Rezept');

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
            $this->addJoinObject($join, 'Rezept');
        }

        return $this;
    }

    /**
     * Use the Rezept relation Rezept object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \RezeptQuery A secondary query class using the current class as primary query
     */
    public function useRezeptQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRezept($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Rezept', '\RezeptQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildRezeptverwaltung $rezeptverwaltung Object to remove from the list of results
     *
     * @return $this|ChildRezeptverwaltungQuery The current query, for fluid interface
     */
    public function prune($rezeptverwaltung = null)
    {
        if ($rezeptverwaltung) {
            throw new LogicException('Rezeptverwaltung object has no primary key');

        }

        return $this;
    }

    /**
     * Deletes all rows from the rezeptverwaltung table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RezeptverwaltungTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            RezeptverwaltungTableMap::clearInstancePool();
            RezeptverwaltungTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(RezeptverwaltungTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(RezeptverwaltungTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            RezeptverwaltungTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            RezeptverwaltungTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // RezeptverwaltungQuery
