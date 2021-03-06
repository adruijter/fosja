<?php
 require_once("MySqlDatabaseClass.php");
 
 // Definieer een constante. Deze waarde kan niet run-time
 // worden gewijzigd.
 define('NUMBER_OF_PHOTOS', 3);
 
 class PhotoClass
 {
 	//Fields
 	private $photo_id;
	private $order_id;
	private $photo_name;
	private $photo_text;
 	
 	//properties
 	
 	//Constructor
 	public function __construct()
	{
		// Gebruiken we nu even niet....
	} 	
 	
 	//Methods
 	public static function insert_into_photo($order_id, $photo_title, 												$photo_name, $photo_text)
	{
		// Maak het $database object uit het MySqlDatabaseClass.php	
		// bestand beschikbaar binnen de insert_into_photo() method
		global $database;
		
		// Maak de insert query
		$query = "INSERT INTO `photo` (`photo_id`,
									   `order_id`,
									   `photo_title`,
									   `photo_name`,
									   `photo_text`)
				  VALUES			  (Null,
				  					   '".$order_id."',
				  					   '".$photo_title."',
				  					   '".$photo_name."',
				  					   '".$photo_text."')";
									   
		//echo $query; exit();
		// Vuur de query af op de database
		$database->fire_query($query);
	}
	
	// Haal de foto's uit de database voor de 
	// pagina bekijk_fotos.php
	public static function show_photos($order_id)
	{
		global $database;
		
		$query = "SELECT *
				  FROM `photo`, `order`
				  WHERE `photo`.`order_id` = '".$order_id."'
				  AND `order`.`order_id` = `photo`.`order_id`";
		//echo $query; exit();
		
		$result = $database->fire_query($query);
		
		// Als er geen fotos beschikbaar zijn dan komt er een
		// melding dat er momenteel geen fotos beschikbaar zijn
		if (mysql_num_rows($result) != 0)
		{
			// Maak een teller
			$teller = 0;
			$counter = 0;
			echo "<tr>";
			  while ( $row = mysql_fetch_array($result))
			  {
			    if ( $teller != NUMBER_OF_PHOTOS)
				{
			      echo "<td>
			    	      <img src='fotos/".$_SESSION['id'].
			    	                    "/".$order_id.
			    	                    "/thumbnail/tn_".
			    	                    $row['photo_name']."' 
			    	           alt='".$row['photo_text']."'
			    	           rel='#test".$counter."'/>
			    	    </td>
			    	    <div class='simple_overlay' id='test".$counter."'>
							<img src='./fotos/".$_SESSION['id']."/".
									$order_id."/".$row['photo_name']."' />
	
							<div class='details'>
								<h3>".$row['order_short']."</h3>
								<h4>".$row['photo_title']."</h4>
								<p>".$row['photo_text']."</p>		
							</div>	
						</div>";
			    	    $teller++;
						$counter++;
			    }
				else 
				{
			      echo "</tr>
			      		  <tr>
			      		    <td>
			    	          <img src='fotos/".$_SESSION['id'].
			    	                        "/".$order_id.
			    	                        "/thumbnail/tn_".
			    	                        $row['photo_name']."' 
			    	               alt='".$row['photo_text']."'
			    	               rel='#test".$counter."'
			    	               />
			    	        </td>
			    	    <div class='simple_overlay' id='test".$counter."'>
							<img src='./fotos/".$_SESSION['id']."/".
									$order_id."/".$row['photo_name']."' />
	
							<div class='details'>
								<h3>".$row['order_short']."</h3>
								<h4>".$row['photo_title']."</h4>
								<p>".$row['photo_text']."</p>		
							</div>	
						</div>";
						$teller = 1;
						$counter++;
				}	
			  }
			echo "</tr>";
		}
		else
		{
			echo "Er zijn momenteel geen foto's beschikbaar";	
		}	
	}

	public static function show_photos_photographer($order_id, $user_id)
	{
		//echo $order_id." <=> ".$user_id; exit();	
			
		global $database;
		
		$query = "SELECT *
				  FROM `photo`, `order`
				  WHERE `order`.`user_id` = '".$user_id."' 
				  AND   `order`.`order_id` = '".$order_id."'
				  AND   `order`.`order_id` = `photo`.`order_id`";
		//echo $query; exit();
		
		$result = $database->fire_query($query);
		
		// Als er geen fotos beschikbaar zijn dan komt er een
		// melding dat er momenteel geen fotos beschikbaar zijn
		if (mysql_num_rows($result) != 0)
		{
			// Maak een teller
			$teller = 0;
			echo "<tr>";
			  while ( $row = mysql_fetch_array($result))
			  {
			    if ( $teller != NUMBER_OF_PHOTOS)
				{
			      echo "<td>
			    	      <img src='fotos/".$user_id.
			    	                    "/".$order_id.
			    	                    "/thumbnail/tn_".
			    	                    $row['photo_name']."' 
			    	           alt='".$row['photo_text']."'/>
			    	    </td>";
			    	    $teller++;
			    }
				else 
				{
			      echo "</tr>
			      		  <tr>
			      		    <td>
			    	          <img src='fotos/".$user_id.
			    	                        "/".$order_id.
			    	                        "/thumbnail/tn_".
			    	                        $row['photo_name']."' 
			    	               alt='".$row['photo_text']."'/>
			    	        </td>";
						$teller = 1;
				}	
			  }
			echo "</tr>";
		}
		else
		{
			echo "Er zijn momenteel geen foto's beschikbaar";	
		}	
	}
 }
?>