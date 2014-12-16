<?php

namespace Base;

use \Projekt as ChildProjekt;
use \ProjektQuery as ChildProjektQuery;
use \Exception;
use \PDO;
use Map\ProjektTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'projekt' table.
 *
 *
 *
 * @method     ChildProjektQuery orderByProjektname($order = Criteria::ASC) Order by the projektname column
 * @method     ChildProjektQuery orderByStartdate($order = Criteria::ASC) Order by the startdate column
 * @method     ChildProjektQuery orderByEnddate($order = Criteria::ASC) Order by the enddate column
 * @method     ChildProjektQuery orderByProjektId($order = Criteria::ASC) Order by the projekt_id column
 *
 * @method     ChildProjektQuery groupByProjektname() Group by the projektname column
 * @method     ChildProjektQuery groupByStartdate() Group by the startdate column
 * @method     ChildProjektQuery groupByEnddate() Group by the enddate column
 * @method     ChildProjektQuery groupByProjektId() Group by the projekt_id column
 *
 * @method     ChildProjektQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildProjektQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildProjektQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildProjektQuery leftJoinnotizen($relationAlias = null) Adds a LEFT JOIN clause to the query using the notizen relation
 * @method     ChildProjektQuery rightJoinnotizen($relationAlias = null) Adds a RIGHT JOIN clause to the query using the notizen relation
 * @method     ChildProjektQuery innerJoinnotizen($relationAlias = null) Adds a INNER JOIN clause to the query using the notizen relation
 *
 * @method     \TeilnehmenQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildProjekt findOne(ConnectionInterface $con = null) Return the first ChildProjekt matching the query
 * @method     ChildProjekt findOneOrCreate(ConnectionInterface $con = null) Return the first ChildProjekt matching the query, or a new ChildProjekt object populated from the query conditions when no match is found
 *
 * @method     ChildProjekt findOneByProjektname(string $projektname) Return the first ChildProjekt filtered by the projektname column
 * @method     ChildProjekt findOneByStartdate(string $startdate) Return the first ChildProjekt filtered by the startdate column
 * @method     ChildProjekt findOneByEnddate(string $enddate) Return the first ChildProjekt filtered by the enddate column
 * @method     ChildProjekt findOneByProjektId(int $projekt_id) Return the first ChildProjekt filtered by the projekt_id column
 *
 * @method     ChildProjekt[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildProjekt objects based on current ModelCriteria
 * @method     ChildProjekt[]|ObjectCollection findByProjektname(string $projektname) Return ChildProjekt objects filtered by the projektname column
 * @method     ChildProjekt[]|ObjectCollection findByStartdate(string $startdate) Return ChildProjekt objects filtered by the startdate column
 * @method     ChildProjekt[]|ObjectCollection findByEnddate(string $enddate) Return ChildProjekt objects filtered by the enddate column
 * @method     ChildProjekt[]|ObjectCollection findByProjektId(int $projekt_id) Return ChildProjekt objects filtered by the projekt_id column
 * @method     ChildProjekt[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ProjektQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Base\ProjektQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'notizen', $modelName = '\\Projekt', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildProjektQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildProjektQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildProjektQuery) {
            return $criteria;
        }
        $query = new ChildProjektQuery();
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
     * @return ChildProjekt|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ProjektTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ProjektTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildProjekt A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT projektname, startdate, enddate, projekt_id FROM projekt WHERE projekt_id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildProjekt $obj */
            $obj = new ChildProjekt();
            $obj->hydrate($row);
            ProjektTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildProjekt|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildProjektQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ProjektTableMap::COL_PROJEKT_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildProjektQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ProjektTableMap::COL_PROJEKT_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the projektname column
     *
     * Example usage:
     * <code>
     * $query->filterByProjektname('fooValue');   // WHERE projektname = 'fooValue'
     * $query->filterByProjektname('%fooValue%'); // WHERE projektname LIKE '%fooValue%'
     * </code>
     *
     * @param     string $projektname The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildProjektQuery The current query, for fluid interface
     */
    public function filterByProjektname($projektname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($projektname)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $projektname)) {
                $projektname = str_replace('*', '%', $projektname);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProjektTableMap::COL_PROJEKTNAME, $projektname, $comparison);
    }

    /**
     * Filter the query on the startdate column
     *
     * Example usage:
     * <code>
     * $query->filterByStartdate('2011-03-14'); // WHERE startdate = '2011-03-14'
     * $query->filterByStartdate('now'); // WHERE startdate = '2011-03-14'
     * $query->filterByStartdate(array('max' => 'yesterday')); // WHERE startdate > '2011-03-13'
     * </code>
     *
     * @param     mixed $startdate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildProjektQuery The current query, for fluid interface
     */
    public function filterByStartdate($startdate = null, $comparison = null)
    {
        if (is_array($startdate)) {
            $useMinMax = false;
            if (isset($startdate['min'])) {
                $this->addUsingAlias(ProjektTableMap::COL_STARTDATE, $startdate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($startdate['max'])) {
                $this->addUsingAlias(ProjektTableMap::COL_STARTDATE, $startdate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjektTableMap::COL_STARTDATE, $startdate, $comparison);
    }

    /**
     * Filter the query on the enddate column
     *
     * Example usage:
     * <code>
     * $query->filterByEnddate('2011-03-14'); // WHERE enddate = '2011-03-14'
     * $query->filterByEnddate('now'); // WHERE enddate = '2011-03-14'
     * $query->filterByEnddate(array('max' => 'yesterday')); // WHERE enddate > '2011-03-13'
     * </code>
     *
     * @param     mixed $enddate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildProjektQuery The current query, for fluid interface
     */
    public function filterByEnddate($enddate = null, $comparison = null)
    {
        if (is_array($enddate)) {
            $useMinMax = false;
            if (isset($enddate['min'])) {
                $this->addUsingAlias(ProjektTableMap::COL_ENDDATE, $enddate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($enddate['max'])) {
                $this->addUsingAlias(ProjektTableMap::COL_ENDDATE, $enddate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjektTableMap::COL_ENDDATE, $enddate, $comparison);
    }

    /**
     * Filter the query on the projekt_id column
     *
     * Example usage:
     * <code>
     * $query->filterByProjektId(1234); // WHERE projekt_id = 1234
     * $query->filterByProjektId(array(12, 34)); // WHERE projekt_id IN (12, 34)
     * $query->filterByProjektId(array('min' => 12)); // WHERE projekt_id > 12
     * </code>
     *
     * @param     mixed $projektId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildProjektQuery The current query, for fluid interface
     */
    public function filterByProjektId($projektId = null, $comparison = null)
    {
        if (is_array($projektId)) {
            $useMinMax = false;
            if (isset($projektId['min'])) {
                $this->addUsingAlias(ProjektTableMap::COL_PROJEKT_ID, $projektId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($projektId['max'])) {
                $this->addUsingAlias(ProjektTableMap::COL_PROJEKT_ID, $projektId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjektTableMap::COL_PROJEKT_ID, $projektId, $comparison);
    }

    /**
     * Filter the query by a related \Teilnehmen object
     *
     * @param \Teilnehmen|ObjectCollection $teilnehmen  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProjektQuery The current query, for fluid interface
     */
    public function filterBynotizen($teilnehmen, $comparison = null)
    {
        if ($teilnehmen instanceof \Teilnehmen) {
            return $this
                ->addUsingAlias(ProjektTableMap::COL_PROJEKT_ID, $teilnehmen->getTid(), $comparison);
        } elseif ($teilnehmen instanceof ObjectCollection) {
            return $this
                ->usenotizenQuery()
                ->filterByPrimaryKeys($teilnehmen->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBynotizen() only accepts arguments of type \Teilnehmen or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the notizen relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildProjektQuery The current query, for fluid interface
     */
    public function joinnotizen($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('notizen');

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
            $this->addJoinObject($join, 'notizen');
        }

        return $this;
    }

    /**
     * Use the notizen relation Teilnehmen object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \TeilnehmenQuery A secondary query class using the current class as primary query
     */
    public function usenotizenQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinnotizen($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'notizen', '\TeilnehmenQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildProjekt $projekt Object to remove from the list of results
     *
     * @return $this|ChildProjektQuery The current query, for fluid interface
     */
    public function prune($projekt = null)
    {
        if ($projekt) {
            $this->addUsingAlias(ProjektTableMap::COL_PROJEKT_ID, $projekt->getProjektId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the projekt table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ProjektTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ProjektTableMap::clearInstancePool();
            ProjektTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ProjektTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ProjektTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ProjektTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ProjektTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ProjektQuery
