<?php
namespace Models;

use Core\Database;

class Tour
{
    protected $db;
    protected $table = 'tour'; 

    public function __construct(Database $db)
    {
        $this->db = $db;
    }



    public function getAllTours()
    {
        $query = "SELECT 
                    tour.id AS tour_id,
                    tour.destination  AS tour_destination,
                    tour.date AS tour_date,
                    tour.tourdate AS tour_tourdate,
                    tour.tourdateEnd AS tour_tourdateEnd,
                    tour.tourtype AS tour_tourtype,    /* JSON format in MySQL */
                    tour.fellowtraveler AS tour_fellowtraveler,
                    tour.aboutme AS tour_aboutme,
    
                    user.id AS user_id,
                    user.firstName AS user_firstName,
                    user.email AS user_email,   
                    user.image AS user_image
                FROM 
                    {$this->table}
                JOIN 
                    user ON {$this->table}.user_id = user.id";
    
        return $this->db->query($query)->findAll();
    }

    public function getFilteredTours($destination, $tourtype, $date)
    {
        // Initialize the base query
        $query = "SELECT 
                    tour.id AS tour_id,
                    tour.destination  AS tour_destination,
                    tour.date AS tour_date,
                    tour.tourdate AS tour_tourdate,
                    tour.tourdateEnd AS tour_tourdateEnd,
                    tour.tourtype AS tour_tourtype,    /* JSON format in MySQL */
                    tour.fellowtraveler AS tour_fellowtraveler,
                    tour.aboutme AS tour_aboutme,
    
                    user.id AS user_id,
                    user.firstName AS user_firstName,
                    user.email AS user_email,   
                    user.image AS user_image
                FROM 
                    {$this->table}
                JOIN 
                    user ON {$this->table}.user_id = user.id
                WHERE 1=1"; // Always true condition to start with
    
        // Prepare to bind parameters
        $params = [];
    
        // Add conditions based on provided filters
        if (!empty($destination)) {
            $query .= " AND tour.destination = :destination";
            $params[':destination'] = $destination;
        }
        if (!empty($tourtype)) {
            // Assuming `tourtype` is stored as JSON in the database
            $query .= " AND JSON_CONTAINS(tour.tourtype, JSON_QUOTE(:tourtype))";
            $params[':tourtype'] = $tourtype;
        }
        if (!empty($date)) {
            // Split date into month and year
            preg_match('/^(\D+)(\d+)$/', $date, $matches);
            $monthName = $matches[1];
            $year = $matches[2];
    
            // Convert month name to month number
            $czechMonths = ['leden' => 1, 'únor' => 2, 'březen' => 3, 'duben' => 4, 'květen' => 5, 'červen' => 6, 'červenec' => 7, 'srpen' => 8, 'září' => 9, 'říjen' => 10, 'listopad' => 11, 'prosinec' => 12];
            $month = $czechMonths[$monthName];
    
            // Construct the SQL condition to match month and year
            $query .= " AND (MONTH(tour.tourdate) = :month AND YEAR(tour.tourdate) = :year OR MONTH(tour.tourdateEnd) = :month AND YEAR(tour.tourdateEnd) = :year)";
            $params[':month'] = $month;
            $params[':year'] = $year;
        }
    
        // Execute the query with parameters
        return $this->db->query($query, $params)->findAll();    
    }
    
    

    public function getTour($tourId)
    {
        $query = "SELECT 
                    tour.id AS tour_id,
                    tour.destination AS tour_destination,
                    tour.date AS tour_date,
                    tour.tourdate AS tour_tourdate,
                    tour.tourdateEnd AS tour_tourdateEnd,
                    tour.tourtype AS tour_tourtype,   /* JSON format in MySQL */
                    tour.fellowtraveler AS tour_fellowtraveler,
                    tour.aboutme AS tour_aboutme,
                    tour.user_id,
    
                    user.id AS user_id,
                    user.firstName AS user_firstName,
                    user.email AS user_email,
                    user.image AS user_image
                FROM 
                    {$this->table}
                JOIN 
                    user ON {$this->table}.user_id = user.id
                WHERE 
                    tour.id = :tourId";
    
            $tour = $this->db->query($query, ['tourId' => $tourId])->find();
            
            // Decode the JSON tour_tourtype
            if ($tour && isset($tour['tour_tourtype'])) {
                $tour['tour_tourtype'] = json_decode($tour['tour_tourtype'], true);
            }

            return $tour;
    }

    public function createTour($destination, $tourdate, $tourdateEnd, $tourtype, $fellowtraveler, $aboutme, $userId) {
        $query = "INSERT INTO {$this->table} (destination, tourdate, tourdateEnd, tourtype, fellowtraveler, aboutme, user_id)
                  VALUES (:destination, :tourdate, :tourdateEnd, :tourtype, :fellowtraveler, :aboutme, :user_id)";

        $this->db->query($query, [
            ':destination' => $destination,
            ':tourdate' => $tourdate,
            ':tourdateEnd' => $tourdateEnd,
            ':tourtype' => json_encode($tourtype, JSON_UNESCAPED_UNICODE),
            ':fellowtraveler' => $fellowtraveler,
            ':aboutme' => $aboutme,
            ':user_id' => $userId,
        ]);
    }

        public function getTourByUser($user_id) {
                $query = "SELECT 
                            tour.id AS tour_id,
                            tour.destination AS tour_destination,
                            tour.date AS tour_date,
                            tour.tourdate AS tour_tourdate,
                            tour.tourdateEnd AS tour_tourdateEnd,
                            tour.tourtype AS tour_tourtype,
                            tour.fellowtraveler AS tour_fellowtraveler,
                            tour.aboutme AS tour_aboutme,
                            user.id AS user_id,
                            user.firstName AS user_firstName,
                            user.email AS user_email,
                            user.image AS user_image
                        FROM 
                            {$this->table}
                        JOIN 
                            user ON tour.user_id = user.id
                        WHERE 
                            tour.user_id = :user_id";
                
                $stmt = $this->db->query($query, [':user_id' => $user_id]);
                return $stmt->findAll();
            }   


            public function getTourById($id)
            {
                $query = "SELECT 
                tour.id AS tour_id,
                tour.destination AS tour_destination,
                tour.date AS tour_date,
                tour.tourdate AS tour_tourdate,
                tour.tourdateEnd AS tour_tourdateEnd,
                tour.tourtype AS tour_tourtype,
                tour.fellowtraveler AS tour_fellowtraveler,
                tour.aboutme AS tour_aboutme,
                user.id AS user_id,
                user.firstName AS user_firstName,
                user.email AS user_email,
                user.image AS user_image
            FROM 
                {$this->table}
            JOIN 
                user ON tour.user_id = user.id
            WHERE 
                tour.id = :id";
    
           
            return $this->db->query($query, [':id' => $id])->findOrFail();
       
            }

            public function deleteTour($id)
            {
                $query = "DELETE FROM  {$this->table}     WHERE id = :id";
                return $this->db->query($query, [':id' => $id]);
            }
        
public function updateTourById($destination, $tourdate, $tourdateEnd, $tourtype, $fellowtraveler, $aboutme, $userId, $tourId) {
    $query = "UPDATE {$this->table}
              SET destination = :destination,
                  tourdate = :tourdate,
                  tourdateEnd = :tourdateEnd,
                  tourtype = :tourtype,
                  fellowtraveler = :fellowtraveler,
                  aboutme = :aboutme,
                  user_id = :user_id
              WHERE id = :tour_id";

    $this->db->query($query, [
        ':destination' => $destination,
        ':tourdate' => $tourdate,
        ':tourdateEnd' => $tourdateEnd,
        ':tourtype' => json_encode($tourtype, JSON_UNESCAPED_UNICODE),
        ':fellowtraveler' => $fellowtraveler,
        ':aboutme' => $aboutme,
        ':user_id' => $userId,
        ':tour_id' => $tourId,
    ]);
}
            
        
}





