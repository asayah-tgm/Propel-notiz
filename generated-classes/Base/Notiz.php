<?php

namespace Base;

use \Notiz as ChildNotiz;
use \NotizQuery as ChildNotizQuery;
use \Person as ChildPerson;
use \PersonQuery as ChildPersonQuery;
use \Rezeptverwaltung as ChildRezeptverwaltung;
use \RezeptverwaltungQuery as ChildRezeptverwaltungQuery;
use \ToDo as ChildToDo;
use \ToDoQuery as ChildToDoQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\NotizTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'notiz' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Notiz implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\NotizTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the betreff field.
     * @var        string
     */
    protected $betreff;

    /**
     * The value for the text field.
     * @var        string
     */
    protected $text;

    /**
     * The value for the datum field.
     * @var        \DateTime
     */
    protected $datum;

    /**
     * The value for the besitzer field.
     * @var        string
     */
    protected $besitzer;

    /**
     * The value for the projekt field.
     * @var        string
     */
    protected $projekt;

    /**
     * The value for the notiz_id field.
     * @var        int
     */
    protected $notiz_id;

    /**
     * The value for the fk_id field.
     * @var        int
     */
    protected $fk_id;

    /**
     * @var        ChildPerson
     */
    protected $aPerson;

    /**
     * @var        ObjectCollection|ChildRezeptverwaltung[] Collection to store aggregation of ChildRezeptverwaltung objects.
     */
    protected $collnotizens;
    protected $collnotizensPartial;

    /**
     * @var        ObjectCollection|ChildToDo[] Collection to store aggregation of ChildToDo objects.
     */
    protected $collnotizens;
    protected $collnotizensPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRezeptverwaltung[]
     */
    protected $notizensScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildToDo[]
     */
    protected $notizensScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Notiz object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Notiz</code> instance.  If
     * <code>obj</code> is an instance of <code>Notiz</code>, delegates to
     * <code>equals(Notiz)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Notiz The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        return array_keys(get_object_vars($this));
    }

    /**
     * Get the [betreff] column value.
     *
     * @return string
     */
    public function getBetreff()
    {
        return $this->betreff;
    }

    /**
     * Get the [text] column value.
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Get the [optionally formatted] temporal [datum] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDatum($format = NULL)
    {
        if ($format === null) {
            return $this->datum;
        } else {
            return $this->datum instanceof \DateTime ? $this->datum->format($format) : null;
        }
    }

    /**
     * Get the [besitzer] column value.
     *
     * @return string
     */
    public function getBesitzer()
    {
        return $this->besitzer;
    }

    /**
     * Get the [projekt] column value.
     *
     * @return string
     */
    public function getProjekt()
    {
        return $this->projekt;
    }

    /**
     * Get the [notiz_id] column value.
     *
     * @return int
     */
    public function getNotizId()
    {
        return $this->notiz_id;
    }

    /**
     * Get the [fk_id] column value.
     *
     * @return int
     */
    public function getFkId()
    {
        return $this->fk_id;
    }

    /**
     * Set the value of [betreff] column.
     *
     * @param  string $v new value
     * @return $this|\Notiz The current object (for fluent API support)
     */
    public function setBetreff($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->betreff !== $v) {
            $this->betreff = $v;
            $this->modifiedColumns[NotizTableMap::COL_BETREFF] = true;
        }

        return $this;
    } // setBetreff()

    /**
     * Set the value of [text] column.
     *
     * @param  string $v new value
     * @return $this|\Notiz The current object (for fluent API support)
     */
    public function setText($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->text !== $v) {
            $this->text = $v;
            $this->modifiedColumns[NotizTableMap::COL_TEXT] = true;
        }

        return $this;
    } // setText()

    /**
     * Sets the value of [datum] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\Notiz The current object (for fluent API support)
     */
    public function setDatum($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->datum !== null || $dt !== null) {
            if ($dt !== $this->datum) {
                $this->datum = $dt;
                $this->modifiedColumns[NotizTableMap::COL_DATUM] = true;
            }
        } // if either are not null

        return $this;
    } // setDatum()

    /**
     * Set the value of [besitzer] column.
     *
     * @param  string $v new value
     * @return $this|\Notiz The current object (for fluent API support)
     */
    public function setBesitzer($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->besitzer !== $v) {
            $this->besitzer = $v;
            $this->modifiedColumns[NotizTableMap::COL_BESITZER] = true;
        }

        return $this;
    } // setBesitzer()

    /**
     * Set the value of [projekt] column.
     *
     * @param  string $v new value
     * @return $this|\Notiz The current object (for fluent API support)
     */
    public function setProjekt($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->projekt !== $v) {
            $this->projekt = $v;
            $this->modifiedColumns[NotizTableMap::COL_PROJEKT] = true;
        }

        return $this;
    } // setProjekt()

    /**
     * Set the value of [notiz_id] column.
     *
     * @param  int $v new value
     * @return $this|\Notiz The current object (for fluent API support)
     */
    public function setNotizId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->notiz_id !== $v) {
            $this->notiz_id = $v;
            $this->modifiedColumns[NotizTableMap::COL_NOTIZ_ID] = true;
        }

        return $this;
    } // setNotizId()

    /**
     * Set the value of [fk_id] column.
     *
     * @param  int $v new value
     * @return $this|\Notiz The current object (for fluent API support)
     */
    public function setFkId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->fk_id !== $v) {
            $this->fk_id = $v;
            $this->modifiedColumns[NotizTableMap::COL_FK_ID] = true;
        }

        if ($this->aPerson !== null && $this->aPerson->getPersonId() !== $v) {
            $this->aPerson = null;
        }

        return $this;
    } // setFkId()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : NotizTableMap::translateFieldName('Betreff', TableMap::TYPE_PHPNAME, $indexType)];
            $this->betreff = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : NotizTableMap::translateFieldName('Text', TableMap::TYPE_PHPNAME, $indexType)];
            $this->text = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : NotizTableMap::translateFieldName('Datum', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->datum = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : NotizTableMap::translateFieldName('Besitzer', TableMap::TYPE_PHPNAME, $indexType)];
            $this->besitzer = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : NotizTableMap::translateFieldName('Projekt', TableMap::TYPE_PHPNAME, $indexType)];
            $this->projekt = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : NotizTableMap::translateFieldName('NotizId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->notiz_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : NotizTableMap::translateFieldName('FkId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->fk_id = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 7; // 7 = NotizTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Notiz'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aPerson !== null && $this->fk_id !== $this->aPerson->getPersonId()) {
            $this->aPerson = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(NotizTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildNotizQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aPerson = null;
            $this->collnotizens = null;

            $this->collnotizens = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Notiz::setDeleted()
     * @see Notiz::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(NotizTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildNotizQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(NotizTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                NotizTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aPerson !== null) {
                if ($this->aPerson->isModified() || $this->aPerson->isNew()) {
                    $affectedRows += $this->aPerson->save($con);
                }
                $this->setPerson($this->aPerson);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            if ($this->notizensScheduledForDeletion !== null) {
                if (!$this->notizensScheduledForDeletion->isEmpty()) {
                    \RezeptverwaltungQuery::create()
                        ->filterByPrimaryKeys($this->notizensScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->notizensScheduledForDeletion = null;
                }
            }

            if ($this->collnotizens !== null) {
                foreach ($this->collnotizens as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->notizensScheduledForDeletion !== null) {
                if (!$this->notizensScheduledForDeletion->isEmpty()) {
                    \ToDoQuery::create()
                        ->filterByPrimaryKeys($this->notizensScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->notizensScheduledForDeletion = null;
                }
            }

            if ($this->collnotizens !== null) {
                foreach ($this->collnotizens as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[NotizTableMap::COL_NOTIZ_ID] = true;
        if (null !== $this->notiz_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . NotizTableMap::COL_NOTIZ_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(NotizTableMap::COL_BETREFF)) {
            $modifiedColumns[':p' . $index++]  = 'betreff';
        }
        if ($this->isColumnModified(NotizTableMap::COL_TEXT)) {
            $modifiedColumns[':p' . $index++]  = 'text';
        }
        if ($this->isColumnModified(NotizTableMap::COL_DATUM)) {
            $modifiedColumns[':p' . $index++]  = 'datum';
        }
        if ($this->isColumnModified(NotizTableMap::COL_BESITZER)) {
            $modifiedColumns[':p' . $index++]  = 'besitzer';
        }
        if ($this->isColumnModified(NotizTableMap::COL_PROJEKT)) {
            $modifiedColumns[':p' . $index++]  = 'projekt';
        }
        if ($this->isColumnModified(NotizTableMap::COL_NOTIZ_ID)) {
            $modifiedColumns[':p' . $index++]  = 'notiz_id';
        }
        if ($this->isColumnModified(NotizTableMap::COL_FK_ID)) {
            $modifiedColumns[':p' . $index++]  = 'fk_id';
        }

        $sql = sprintf(
            'INSERT INTO notiz (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'betreff':
                        $stmt->bindValue($identifier, $this->betreff, PDO::PARAM_STR);
                        break;
                    case 'text':
                        $stmt->bindValue($identifier, $this->text, PDO::PARAM_STR);
                        break;
                    case 'datum':
                        $stmt->bindValue($identifier, $this->datum ? $this->datum->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'besitzer':
                        $stmt->bindValue($identifier, $this->besitzer, PDO::PARAM_STR);
                        break;
                    case 'projekt':
                        $stmt->bindValue($identifier, $this->projekt, PDO::PARAM_STR);
                        break;
                    case 'notiz_id':
                        $stmt->bindValue($identifier, $this->notiz_id, PDO::PARAM_INT);
                        break;
                    case 'fk_id':
                        $stmt->bindValue($identifier, $this->fk_id, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setNotizId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = NotizTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getBetreff();
                break;
            case 1:
                return $this->getText();
                break;
            case 2:
                return $this->getDatum();
                break;
            case 3:
                return $this->getBesitzer();
                break;
            case 4:
                return $this->getProjekt();
                break;
            case 5:
                return $this->getNotizId();
                break;
            case 6:
                return $this->getFkId();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Notiz'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Notiz'][$this->hashCode()] = true;
        $keys = NotizTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getBetreff(),
            $keys[1] => $this->getText(),
            $keys[2] => $this->getDatum(),
            $keys[3] => $this->getBesitzer(),
            $keys[4] => $this->getProjekt(),
            $keys[5] => $this->getNotizId(),
            $keys[6] => $this->getFkId(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aPerson) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'person';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'person';
                        break;
                    default:
                        $key = 'Person';
                }

                $result[$key] = $this->aPerson->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collnotizens) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'rezeptverwaltungs';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'rezeptverwaltungs';
                        break;
                    default:
                        $key = 'Rezeptverwaltungs';
                }

                $result[$key] = $this->collnotizens->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collnotizens) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'toDos';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'toDos';
                        break;
                    default:
                        $key = 'ToDos';
                }

                $result[$key] = $this->collnotizens->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\Notiz
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = NotizTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Notiz
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setBetreff($value);
                break;
            case 1:
                $this->setText($value);
                break;
            case 2:
                $this->setDatum($value);
                break;
            case 3:
                $this->setBesitzer($value);
                break;
            case 4:
                $this->setProjekt($value);
                break;
            case 5:
                $this->setNotizId($value);
                break;
            case 6:
                $this->setFkId($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = NotizTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setBetreff($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setText($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setDatum($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setBesitzer($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setProjekt($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setNotizId($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setFkId($arr[$keys[6]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     *
     * @return $this|\Notiz The current object, for fluid interface
     */
    public function importFrom($parser, $data)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), TableMap::TYPE_PHPNAME);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(NotizTableMap::DATABASE_NAME);

        if ($this->isColumnModified(NotizTableMap::COL_BETREFF)) {
            $criteria->add(NotizTableMap::COL_BETREFF, $this->betreff);
        }
        if ($this->isColumnModified(NotizTableMap::COL_TEXT)) {
            $criteria->add(NotizTableMap::COL_TEXT, $this->text);
        }
        if ($this->isColumnModified(NotizTableMap::COL_DATUM)) {
            $criteria->add(NotizTableMap::COL_DATUM, $this->datum);
        }
        if ($this->isColumnModified(NotizTableMap::COL_BESITZER)) {
            $criteria->add(NotizTableMap::COL_BESITZER, $this->besitzer);
        }
        if ($this->isColumnModified(NotizTableMap::COL_PROJEKT)) {
            $criteria->add(NotizTableMap::COL_PROJEKT, $this->projekt);
        }
        if ($this->isColumnModified(NotizTableMap::COL_NOTIZ_ID)) {
            $criteria->add(NotizTableMap::COL_NOTIZ_ID, $this->notiz_id);
        }
        if ($this->isColumnModified(NotizTableMap::COL_FK_ID)) {
            $criteria->add(NotizTableMap::COL_FK_ID, $this->fk_id);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildNotizQuery::create();
        $criteria->add(NotizTableMap::COL_NOTIZ_ID, $this->notiz_id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getNotizId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getNotizId();
    }

    /**
     * Generic method to set the primary key (notiz_id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setNotizId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getNotizId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Notiz (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setBetreff($this->getBetreff());
        $copyObj->setText($this->getText());
        $copyObj->setDatum($this->getDatum());
        $copyObj->setBesitzer($this->getBesitzer());
        $copyObj->setProjekt($this->getProjekt());
        $copyObj->setFkId($this->getFkId());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getnotizens() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addnotizen($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getnotizens() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addnotizen($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setNotizId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Notiz Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildPerson object.
     *
     * @param  ChildPerson $v
     * @return $this|\Notiz The current object (for fluent API support)
     * @throws PropelException
     */
    public function setPerson(ChildPerson $v = null)
    {
        if ($v === null) {
            $this->setFkId(NULL);
        } else {
            $this->setFkId($v->getPersonId());
        }

        $this->aPerson = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildPerson object, it will not be re-added.
        if ($v !== null) {
            $v->addnotizen($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildPerson object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildPerson The associated ChildPerson object.
     * @throws PropelException
     */
    public function getPerson(ConnectionInterface $con = null)
    {
        if ($this->aPerson === null && ($this->fk_id !== null)) {
            $this->aPerson = ChildPersonQuery::create()->findPk($this->fk_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aPerson->addnotizens($this);
             */
        }

        return $this->aPerson;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('notizen' == $relationName) {
            return $this->initnotizens();
        }
        if ('notizen' == $relationName) {
            return $this->initnotizens();
        }
    }

    /**
     * Clears out the collnotizens collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addnotizens()
     */
    public function clearnotizens()
    {
        $this->collnotizens = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collnotizens collection loaded partially.
     */
    public function resetPartialnotizens($v = true)
    {
        $this->collnotizensPartial = $v;
    }

    /**
     * Initializes the collnotizens collection.
     *
     * By default this just sets the collnotizens collection to an empty array (like clearcollnotizens());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initnotizens($overrideExisting = true)
    {
        if (null !== $this->collnotizens && !$overrideExisting) {
            return;
        }
        $this->collnotizens = new ObjectCollection();
        $this->collnotizens->setModel('\Rezeptverwaltung');
    }

    /**
     * Gets an array of ChildRezeptverwaltung objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildNotiz is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRezeptverwaltung[] List of ChildRezeptverwaltung objects
     * @throws PropelException
     */
    public function getnotizens(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collnotizensPartial && !$this->isNew();
        if (null === $this->collnotizens || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collnotizens) {
                // return empty collection
                $this->initnotizens();
            } else {
                $collnotizens = ChildRezeptverwaltungQuery::create(null, $criteria)
                    ->filterByNotiz($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collnotizensPartial && count($collnotizens)) {
                        $this->initnotizens(false);

                        foreach ($collnotizens as $obj) {
                            if (false == $this->collnotizens->contains($obj)) {
                                $this->collnotizens->append($obj);
                            }
                        }

                        $this->collnotizensPartial = true;
                    }

                    return $collnotizens;
                }

                if ($partial && $this->collnotizens) {
                    foreach ($this->collnotizens as $obj) {
                        if ($obj->isNew()) {
                            $collnotizens[] = $obj;
                        }
                    }
                }

                $this->collnotizens = $collnotizens;
                $this->collnotizensPartial = false;
            }
        }

        return $this->collnotizens;
    }

    /**
     * Sets a collection of ChildRezeptverwaltung objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $notizens A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildNotiz The current object (for fluent API support)
     */
    public function setnotizens(Collection $notizens, ConnectionInterface $con = null)
    {
        /** @var ChildRezeptverwaltung[] $notizensToDelete */
        $notizensToDelete = $this->getnotizens(new Criteria(), $con)->diff($notizens);


        $this->notizensScheduledForDeletion = $notizensToDelete;

        foreach ($notizensToDelete as $notizenRemoved) {
            $notizenRemoved->setNotiz(null);
        }

        $this->collnotizens = null;
        foreach ($notizens as $notizen) {
            $this->addnotizen($notizen);
        }

        $this->collnotizens = $notizens;
        $this->collnotizensPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Rezeptverwaltung objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Rezeptverwaltung objects.
     * @throws PropelException
     */
    public function countnotizens(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collnotizensPartial && !$this->isNew();
        if (null === $this->collnotizens || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collnotizens) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getnotizens());
            }

            $query = ChildRezeptverwaltungQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByNotiz($this)
                ->count($con);
        }

        return count($this->collnotizens);
    }

    /**
     * Method called to associate a ChildRezeptverwaltung object to this object
     * through the ChildRezeptverwaltung foreign key attribute.
     *
     * @param  ChildRezeptverwaltung $l ChildRezeptverwaltung
     * @return $this|\Notiz The current object (for fluent API support)
     */
    public function addnotizen(ChildRezeptverwaltung $l)
    {
        if ($this->collnotizens === null) {
            $this->initnotizens();
            $this->collnotizensPartial = true;
        }

        if (!$this->collnotizens->contains($l)) {
            $this->doAddnotizen($l);
        }

        return $this;
    }

    /**
     * @param ChildRezeptverwaltung $notizen The ChildRezeptverwaltung object to add.
     */
    protected function doAddnotizen(ChildRezeptverwaltung $notizen)
    {
        $this->collnotizens[]= $notizen;
        $notizen->setNotiz($this);
    }

    /**
     * @param  ChildRezeptverwaltung $notizen The ChildRezeptverwaltung object to remove.
     * @return $this|ChildNotiz The current object (for fluent API support)
     */
    public function removenotizen(ChildRezeptverwaltung $notizen)
    {
        if ($this->getnotizens()->contains($notizen)) {
            $pos = $this->collnotizens->search($notizen);
            $this->collnotizens->remove($pos);
            if (null === $this->notizensScheduledForDeletion) {
                $this->notizensScheduledForDeletion = clone $this->collnotizens;
                $this->notizensScheduledForDeletion->clear();
            }
            $this->notizensScheduledForDeletion[]= clone $notizen;
            $notizen->setNotiz(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Notiz is new, it will return
     * an empty collection; or if this Notiz has previously
     * been saved, it will retrieve related notizens from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Notiz.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRezeptverwaltung[] List of ChildRezeptverwaltung objects
     */
    public function getnotizensJoinRezept(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRezeptverwaltungQuery::create(null, $criteria);
        $query->joinWith('Rezept', $joinBehavior);

        return $this->getnotizens($query, $con);
    }

    /**
     * Clears out the collnotizens collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addnotizens()
     */
    public function clearnotizens()
    {
        $this->collnotizens = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collnotizens collection loaded partially.
     */
    public function resetPartialnotizens($v = true)
    {
        $this->collnotizensPartial = $v;
    }

    /**
     * Initializes the collnotizens collection.
     *
     * By default this just sets the collnotizens collection to an empty array (like clearcollnotizens());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initnotizens($overrideExisting = true)
    {
        if (null !== $this->collnotizens && !$overrideExisting) {
            return;
        }
        $this->collnotizens = new ObjectCollection();
        $this->collnotizens->setModel('\ToDo');
    }

    /**
     * Gets an array of ChildToDo objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildNotiz is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildToDo[] List of ChildToDo objects
     * @throws PropelException
     */
    public function getnotizens(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collnotizensPartial && !$this->isNew();
        if (null === $this->collnotizens || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collnotizens) {
                // return empty collection
                $this->initnotizens();
            } else {
                $collnotizens = ChildToDoQuery::create(null, $criteria)
                    ->filterByNotiz($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collnotizensPartial && count($collnotizens)) {
                        $this->initnotizens(false);

                        foreach ($collnotizens as $obj) {
                            if (false == $this->collnotizens->contains($obj)) {
                                $this->collnotizens->append($obj);
                            }
                        }

                        $this->collnotizensPartial = true;
                    }

                    return $collnotizens;
                }

                if ($partial && $this->collnotizens) {
                    foreach ($this->collnotizens as $obj) {
                        if ($obj->isNew()) {
                            $collnotizens[] = $obj;
                        }
                    }
                }

                $this->collnotizens = $collnotizens;
                $this->collnotizensPartial = false;
            }
        }

        return $this->collnotizens;
    }

    /**
     * Sets a collection of ChildToDo objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $notizens A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildNotiz The current object (for fluent API support)
     */
    public function setnotizens(Collection $notizens, ConnectionInterface $con = null)
    {
        /** @var ChildToDo[] $notizensToDelete */
        $notizensToDelete = $this->getnotizens(new Criteria(), $con)->diff($notizens);


        $this->notizensScheduledForDeletion = $notizensToDelete;

        foreach ($notizensToDelete as $notizenRemoved) {
            $notizenRemoved->setNotiz(null);
        }

        $this->collnotizens = null;
        foreach ($notizens as $notizen) {
            $this->addnotizen($notizen);
        }

        $this->collnotizens = $notizens;
        $this->collnotizensPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ToDo objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related ToDo objects.
     * @throws PropelException
     */
    public function countnotizens(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collnotizensPartial && !$this->isNew();
        if (null === $this->collnotizens || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collnotizens) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getnotizens());
            }

            $query = ChildToDoQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByNotiz($this)
                ->count($con);
        }

        return count($this->collnotizens);
    }

    /**
     * Method called to associate a ChildToDo object to this object
     * through the ChildToDo foreign key attribute.
     *
     * @param  ChildToDo $l ChildToDo
     * @return $this|\Notiz The current object (for fluent API support)
     */
    public function addnotizen(ChildToDo $l)
    {
        if ($this->collnotizens === null) {
            $this->initnotizens();
            $this->collnotizensPartial = true;
        }

        if (!$this->collnotizens->contains($l)) {
            $this->doAddnotizen($l);
        }

        return $this;
    }

    /**
     * @param ChildToDo $notizen The ChildToDo object to add.
     */
    protected function doAddnotizen(ChildToDo $notizen)
    {
        $this->collnotizens[]= $notizen;
        $notizen->setNotiz($this);
    }

    /**
     * @param  ChildToDo $notizen The ChildToDo object to remove.
     * @return $this|ChildNotiz The current object (for fluent API support)
     */
    public function removenotizen(ChildToDo $notizen)
    {
        if ($this->getnotizens()->contains($notizen)) {
            $pos = $this->collnotizens->search($notizen);
            $this->collnotizens->remove($pos);
            if (null === $this->notizensScheduledForDeletion) {
                $this->notizensScheduledForDeletion = clone $this->collnotizens;
                $this->notizensScheduledForDeletion->clear();
            }
            $this->notizensScheduledForDeletion[]= clone $notizen;
            $notizen->setNotiz(null);
        }

        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aPerson) {
            $this->aPerson->removenotizen($this);
        }
        $this->betreff = null;
        $this->text = null;
        $this->datum = null;
        $this->besitzer = null;
        $this->projekt = null;
        $this->notiz_id = null;
        $this->fk_id = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collnotizens) {
                foreach ($this->collnotizens as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collnotizens) {
                foreach ($this->collnotizens as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collnotizens = null;
        $this->collnotizens = null;
        $this->aPerson = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(NotizTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
