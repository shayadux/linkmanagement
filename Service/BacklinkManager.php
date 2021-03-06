<?php

namespace Shaythamc\LinkManagementBundle\Service;

class BacklinkManager{

	protected $database;

	public function __construct(Database $database){
		$this->database = $database;
	}

	/**
	 * Add a backlink to the Backlinks table
	 * @param array $backlinkArray
	 * @return boolean
	 */
	public function addBacklink($backlinkArray){

		// This field is autogenerated by the database, so we won't set it here
		unset($backlinkArray['backlinkId']);
        unset($backlinkArray['lastChecked']);

        // These fields are updated by the BacklinkChecker, so we won't set it here
        unset($backlinkArray['urlStatus']);
		unset($backlinkArray['visible']);
        unset($backlinkArray['anchorText']);
		unset($backlinkArray['anchorStatus']);
		unset($backlinkArray['nofollowStatus']);
        unset($backlinkArray['alive']);

		// Create a date and format it for the database
		unset($backlinkArray['dateAdded']); // = date("j-n-Y");

		// Prepend a colon to each array key to format it for our
		// prepared statement
		$data = array();
		foreach($backlinkArray as $key => $backlinkAttribute){

			$data[':' . $key] = $backlinkAttribute;

		}

		// The query
		$query = 'INSERT INTO Backlinks(display_text, url, expiration, siteId) VALUES(:displayText, :url, :expiration, :siteId)';

		// Access the database, send the query and update it
		try{
            $this->database->update($query, $data);
        }
        // Give us a warning/error msg if it doesnt work
        catch(Exception $e){
            throw new Exception($e->getMessage());
        }

	}

	/**
	 * Get all the backlinks
	 * @result array
	 */
	public function getAllBacklinks(){
		$query = 'SELECT * FROM Backlinks';

        try{
            return $this->database->retrieve($query);
        }
        catch(Exception $e){
            throw new Exception($e->getMessage());
        }
	}

    public function updateAnchorText($backlinkId, $anchorText){

        $query = 'UPDATE Backlinks SET anchor_text = :anchorText WHERE backlinkId = :backlinkId';
        $data = array(
                    ':anchorText' => $anchorText,
                    ':backlinkId' => $backlinkId,
            );

        try{
            $this->database->update($query, $data);
        }
        catch(Exception $e){
            throw new Exception($e->getMessage());
        }

    }

    /**
     * Update the anchor_status field inside the Backlinks table
     * @param type $backlinkId
     * @param type $anchorStatus
     */
    public function updateAnchorStatus($backlinkId, $anchorStatus){

        $query = 'UPDATE Backlinks SET anchor_status = :anchorStatus WHERE backlinkId = :backlinkId';
        $data = array(
                    ':anchorStatus' => $anchorStatus,
                    ':backlinkId' => $backlinkId,
            );

        try{
            $this->database->update($query, $data);
            return true;
        }
        catch(Exception $e){
            throw new Exception($e->getMessage());
        }

    }

    /**
     * Update the url_status inside the Backlinks table
     * @param type $backlinkId
     * @param type $urlStatus
     */
    public function updateUrlStatus($backlinkId, $urlStatus){
        $query = 'UPDATE Backlinks SET url_status = :urlStatus WHERE backlinkId = :backlinkId';
        $data = array(
                ':urlStatus' => $urlStatus,
                ':backlinkId' => $backlinkId
            );

        try{
            $this->database->update($query, $data);
        }
        catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Update the nofollow_status inside the Backlinks table
     * @param type $backlinkId
     * @param type $nofollowStatus
     */
    public function updateNofollowStatus($backlinkId, $nofollowStatus){
        $query = 'UPDATE Backlinks SET nofollow_status = :nofollowStatus WHERE backlinkId = :backlinkId';
        $data = array(
                    ':nofollowStatus' => $nofollowStatus,
                    ':backlinkId' => $backlinkId,
            );

        try{
            $this->database->update($query, $data);
        }
        catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Get information necessary to begin checking links
     * @return type
     */
    public function getAllBacklinkUrls(){
        $query = 'SELECT backlinkId, display_text, url, siteId FROM Backlinks';
        return $this->database->retrieve($query);
    }

    /**
     * Get our desired display text, this is what we compare the external anchor text against
     * @param type $backlinkId
     * @return type
     */
    public function getBacklinkDisplayText($backlinkId){
        $query = 'SELECT display_text FROM Backlinks WHERE backlinkId = :backlinkId';
        $data = array(':backlinkId' => $backlinkId);
        $result = $this->database->retrieve($query, $data);
        return $result[0]['display_text'];
    }

    /**
     * Get a backlink's URL
     * @param type $backlinkId
     * @return type
     */
    public function getBacklinkUrl($backlinkId){
        $query = 'SELECT url FROM Backlinks WHERE backlinkId = :backlinkId';
        $data = array(':backlinkId' => $backlinkId);
        $result = $this->database->retrieve($query, $data);
        return $result[0]['url'];
    }


    public function getAllBacklinkUrlStatus(){
        $query = 'SELECT url_status, backlinkId FROM Backlinks';
        return $this->database->retrieve($query);
    }

    public function getAllBacklinkAnchorStatus(){
        $query = 'SELECT anchor_status, backlinkId FROM Backlinks';
        return $this->database->retrieve($query);
    }

    public function getAllBacklinkNofollowStatus(){
        $query = 'SELECT nofollow_status, backlinkId FROM Backlinks';
        return $this->database->retrieve($query);
    }

    public function getAllBacklinkSiteId(){
        $query = 'SELECT siteId, backlinkId FROM Backlinks';
        return $this->database->retrieve($query);
    }

    public function getBacklinkBySiteId($siteId){
        $query = 'SELECT backlinkId, display_text, url FROM Backlinks WHERE siteId = :siteId';
        $data = array(
                    ':siteId' => $siteId,
                );
        return $this->database->retrieve($query, $data);
    }

    public function getBacklinkSite($siteId){
        $query = 'SELECT Sites.url, Sites.title FROM Sites INNER JOIN Backlinks ON Sites.siteId = Backlinks.siteId WHERE Sites.siteId = :siteId';
        $data = array(
                    ':siteId' => $siteId,
            );

        $result = $this->database->retrieve($query, $data);
        return $result[0];

    }



}
