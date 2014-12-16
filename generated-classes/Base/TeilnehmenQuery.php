<?php

namespace Base;

use \Teilnehmen as ChildTeilnehmen;
use \TeilnehmenQuery as ChildTeilnehmenQuery;
use \Exception;
use Map\TeilnehmenTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'teilnehmen' table.
 *
 *
 *
 * @method     ChildTeilnehmenQuery orderByPid($order = Criteria::ASC) Order by the pid column
 * @method     ChildTeilnehmenQuery orderByTid($order = Criteria::ASC) Order by the tid column
 *
 * @method     ChildTeilnehmenQuery groupByPid() Group by the pid column
 * @method     ChildTeilnehmenQuery groupByTid() Group by the tid column
 *
 * @method     ChildTeilnehmenQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTeilnehmenQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTeilnehmenQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTeilnehmenQuery leftJoinPerson($relationAlias = null) Adds a LEFT JOIN clause to the query using the Person relation
 * @method     ChildTeilnehmenQuery rightJoinPerson($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Person relation
 * @method     ChildTeilnehmenQuery innerJoinPerson($relationAlias = null) Adds a INNER JOIN clause to the query using the Person relation
 *
 * @method     ChildTeilnehmenQuery leftJoinProjekt($relationAlias = null) Adds a LEFT JOIN clause to the query using the Projekt relation
 * @method     ChildTeilnehmenQuery rightJoinProjekt($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Projekt relation
 * @method     ChildTeilnehmenQuery innerJoinProjekt($relationAlias = null) Adds a INNER JOIN clause to the query using the Projekt relation
 *
 * @method     \PersonQuery|\ProjektQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildTeilnehmen findOne(ConnectionInterface $con = null) Return the first ChildTeilnehmen matching the query
 * @method     ChildTeilnehmen findOneOrCreate(ConnectionInterface $con = null) Return the first ChildTeilnehmen matching the query, or a new ChildTeilnehmen object populated from the query conditions when no match is found
 *
 * @method     ChildTeilnehmen findOneByPid(int $pid) Return the first ChildTeilnehmen filtered by the pid column
 * @method     ChildTeilnehmen findOneByTid(int $tid) Return the first ChildTeilnehmen filtered by the tid column
 *
 * @method     ChildTeilnehmen[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildTeilnehmen objects based on current ModelCriteria
 * @method     ChildTeilnehmen[]|ObjectCollection findByPid(int $pid) Return ChildTeilnehmen objects filtered by the pid column
 * @method     ChildTeilnehmen[]|ObjectCollection findByTid(int $tid) Return ChildTeilnehmen objects filtered by the tid column
 * @method     ChildTeilnehmen[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class TeilnehmenQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Base\TeilnehmenQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'notizen', $modelName = '\\Teilnehmen', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTeilnehmenQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTeilnehmenQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildTeilnehmenQuery) {
            return $criteria;
        }
        $query = new ChildTeilnehmenQuery();
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
     * @return ChildTeilnehmen|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        throw new LogicException('The Teilnehmen object has no primary key');
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
        throw new LogicException('The Teilnehmen object has no primary key');
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildTeilnehmenQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        throw new LogicException('The Teilnehmen object has no primary key');
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildTeilnehmenQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        throw new LogicException('The Teilnehmen object has no primary key');
    }

    /**
     * Filter the query on the pid column
     *
     * Example usage:
     * <code>
     * $query->filterByPid(1234); // WHERE pid = 1234
     * $query->filterByPid(array(12, 34)); // WHERE pid IN (12, 34)
     * $query->filterByPid(array('min' => 12)); // WHERE pid > 12
     * </code>
     *
     * @see       filterByPerson()
     *
     * @param     mixed $pid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTeilnehmenQuery The current query, for fluid interface
     */
    public function filterByPid($pid = null, $comparison = null)
    {
        if (is_array($pid)) {
            $useMinMax = false;
            if (isset($pid['min'])) {
                $this->addUsingAlias(TeilnehmenTableMap::COL_PID, $pid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pid['max'])) {
                $this->addUsingAlias(TeilnehmenTableMap::COL_PID, $pid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TeilnehmenTableMap::COL_PID, $pid, $comparison);
    }

    /**
     * Filter the query on the tid column
     *
     * Example usage:
     * <code>
     * $query->filterByTid(1234); // WHERE tid = 1234
     * $query->filterByTid(array(12, 34)); // WHERE tid IN (12, 34)
     * $query->filterByTid(array('min' => 12)); // WHERE tid > 12
     * </code>
     *
     * @see       filterByProjekt()
     *
     * @param     mixed $tid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTeilnehmenQuery The current query, for fluid interface
     */
    public function filterByTid($tid = null, $comparison = null)
    {
        if (is_array($tid)) {
            $useMinMax = false;
            if (isset($tid['min'])) {
                $this->addUsingAlias(TeilnehmenTableMap::COL_TID, $tid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($tid['max'])) {
                $this->addUsingAlias(TeilnehmenTableMap::COL_TID, $tid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TeilnehmenTableMap::COL_TID, $tid, $comparison);
    }

    /**
     * Filter the query by a related \Person object
     *
     * @param \Person|ObjectCollection $person The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTeilnehmenQuery The current query, for fluid interface
     */
    public function filterByPerson($person, $comparison = null)
    {
        if ($person instanceof \Person) {
            return $this
                ->addUsingAlias(TeilnehmenTableMap::COL_PID, $person->getPersonId(), $comparison);
        } elseif ($person instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TeilnehmenTableMap::COL_PID, $person->toKeyValue('PrimaryKey', 'PersonId'), $comparison);
        } else {
            throw new PropelException('filterByPerson() only accepts arguments of type \Person or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Person relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTeilnehmenQuery The current query, for fluid interface
     */
    public function joinPerson($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Person');

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
            $this->addJoinObject($join, 'Person');
        }

        return $this;
    }

    /**
     * Use the Person relation Person object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PersonQuery A secondary query class using the current class as primary query
     */
    public function usePersonQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPerson($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Person', '\PersonQuery');
    }

    /**
     * Filter the query by a related \Projekt object
     *
     * @param \Projekt|ObjectCollection $projekt The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTeilnehmenQuery The current query, for fluid interface
     */
    public function filterByProjekt($projekt, $comparison = null)
    {
        if ($projekt instanceof \Projekt) {
            return $this
                ->addUsingAlias(TeilnehmenTableMap::COL_TID, $projekt->getProjektId(), $comparison);
        } elseif ($projekt instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TeilnehmenTableMap::COL_TID, $projekt->toKeyValue('PrimaryKey', 'ProjektId'), $comparison);
        } else {
            throw new PropelException('filterByProjekt() only accepts arguments of type \Projekt or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Projekt relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTeilnehmenQuery The current query, for fluid interface
     */
    public function joinProjekt($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Projekt');

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
            $this->addJoinObject($join, 'Projekt');
        }

        return $this;
    }

    /**
     * Use the Projekt relation Projekt object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ProjektQuery A secondary query class using the current class as primary query
     */
    public function useProjektQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProjekt($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Projekt', '\ProjektQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildTeilnehmen $teilnehmen Object to remove from the list of results
     *
     * @return $this|ChildTeilnehmenQuery The current query, for fluid interface
     */
    public function prune($teilnehmen = null)
    {
        if ($teilnehmen) {
            throw new LogicException('Teilnehmen object has no primary key');

        }

        return $this;
    }

    /**
     * Deletes all rows from the teilnehmen table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TeilnehmenTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TeilnehmenTableMap::clearInstancePool();
            TeilnehmenTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(TeilnehmenTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TeilnehmenTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            TeilnehmenTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            TeilnehmenTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // TeilnehmenQuery
