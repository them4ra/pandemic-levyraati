<?php

class Raati {
	public function get_all_levyt() {
	   global $pdo;

	   $query = $pdo->prepare("SELECT * FROM songs ORDER BY thetime DESC");
	   $query->execute();

	   return $query->fetchAll();
	}

	public function get_all_ratings() {
	   global $pdo;

	   $query = $pdo->prepare("SELECT * FROM ratings");
	   $query->execute();

	   return $query->fetchAll();
	}

  public function get_ratings($songid) {
     global $pdo;

     $query = $pdo->prepare("SELECT * FROM ratings WHERE songid = ?");
     $query->bindValue(1, $songid);
     $query->execute();

     return $query->fetchAll();
  }

	public function get_themes() {
     global $pdo;

     $query = $pdo->prepare("SELECT * FROM themes");
     $query->execute();

     return $query->fetchAll();
  }

	public function get_banger($songid) {
     global $pdo;

     $query = $pdo->prepare("SELECT * FROM songs WHERE songid = ?");
     $query->bindValue(1, $songid);
     $query->execute();

     return $query->fetch();
  }

		public function todays_disco() {
			 global $pdo;
			 $currenttime = time();
			 $wantedtime = ($currenttime-86400);

			 $query = $pdo->prepare("SELECT * FROM songs WHERE thetime >= ? ORDER BY thetime DESC");
			 $query->bindValue(1, $wantedtime);
			 $query->execute();

			 return $query->fetchAll();
		}

		public function get_date_levyt($thedate) {
		   global $pdo;

		   $query = $pdo->prepare("SELECT * FROM songs WHERE thetime >= ? ORDER BY thetime DESC");
			 $query->bindValue(1, ($thedate -86400));
		   $query->execute();

		   return $query->fetchAll();
		}


		public function get_all_users() {
		   global $pdo;

		   $query = $pdo->prepare("SELECT * FROM users");
		   $query->execute();

		   return $query->fetchAll();
		}

		public function get_all_user_songs($username) {
			 global $pdo;

			 $query = $pdo->prepare("SELECT * FROM songs WHERE author = ? ORDER BY thetime DESC");
			 $query->bindValue(1, $username);
			 $query->execute();

			 return $query->fetchAll();
		}

		public function get_top10($wantedtime) {
			 global $pdo;

			 $query = $pdo->prepare("SELECT songby, songid, AVG(rating) FROM ratings WHERE thetime >= ? GROUP BY songid ORDER BY 3 DESC LIMIT 10;");
			 $query->bindValue(1, $wantedtime);
			 $query->execute();

			 return $query->fetchAll();
		}

		public function get_top10alltime($wantedtime) {
			 global $pdo;

			 $query = $pdo->prepare("SELECT songby, songid, AVG(rating) FROM ratings WHERE thetime >= ? GROUP BY songid ORDER BY 3 DESC LIMIT 25;");
			 $query->bindValue(1, $wantedtime);
			 $query->execute();

			 return $query->fetchAll();
		}

		public function get_top10_2021() {
			 global $pdo;

			 $query = $pdo->prepare("SELECT songby, songid, AVG(rating) FROM ratings WHERE thetime BETWEEN 1641074400 AND 1672264800 GROUP BY songid ORDER BY 3 DESC LIMIT 25;");
			 $query->bindValue(1, $wantedtime);
			 $query->execute();

			 return $query->fetchAll();
		}

		public function get_top10_afterhour($wantedtime) {
			 global $pdo;

			 $query = $pdo->prepare("SELECT songby, songid, AVG(rating), COUNT(rating) FROM ratings WHERE thetime >= ? GROUP BY songid HAVING COUNT(rating) > 2 ORDER BY 3 DESC LIMIT 25;");
			 $query->bindValue(1, $wantedtime);
			 $query->execute();

			 return $query->fetchAll();
		}

		public function martinratedwith10($wantedtime) {
			 global $pdo;

			 $query = $pdo->prepare("SELECT songby, songid, AVG(rating), COUNT(rating) FROM ratings WHERE thetime >= ? GROUP BY songid HAVING COUNT(rating) > 2 ORDER BY 3 DESC LIMIT 10;");
			 $query->bindValue(1, $wantedtime);
			 $query->execute();

			 return $query->fetchAll();
		}

		public function janneratedwith10($wantedtime) {
			global $pdo;

			$query = $pdo->prepare("SELECT songby, songid, AVG(rating), COUNT(rating) FROM ratings WHERE thetime >= ? GROUP BY songid HAVING COUNT(rating) > 3 ORDER BY 3 ASC LIMIT 10;");
			$query->bindValue(1, $wantedtime);
			$query->execute();

			return $query->fetchAll();
	   }

	   public function get_100_top10_afterhour($wantedtime) {
		global $pdo;

		$query = $pdo->prepare("SELECT songby, songid, AVG(rating), COUNT(rating) FROM ratings WHERE thetime >= ? GROUP BY songid HAVING COUNT(rating) > 2 ORDER BY 3 ASC LIMIT 25;");
		$query->bindValue(1, $wantedtime);
		$query->execute();

		return $query->fetchAll();
   }

		public function get_bottom10($wantedtime) {
			 global $pdo;

			 $query = $pdo->prepare("SELECT songby, songid, AVG(rating) FROM ratings WHERE thetime >= ? GROUP BY songid ORDER BY 3 ASC LIMIT 10;");
			 $query->bindValue(1, $wantedtime);
			 $query->execute();

			 return $query->fetchAll();
		}

		public function get_bottom10alltime($wantedtime) {
			 global $pdo;

			 $query = $pdo->prepare("SELECT songby, songid, AVG(rating) FROM ratings WHERE thetime >= ? GROUP BY songid ORDER BY 3 ASC LIMIT 25;");
			 $query->bindValue(1, $wantedtime);
			 $query->execute();

			 return $query->fetchAll();
		}

		public function get_bottom10_2021() {
			 global $pdo;

			 $query = $pdo->prepare("SELECT songby, songid, AVG(rating) FROM ratings WHERE thetime BETWEEN 1641074400 AND 1672264800 GROUP BY songid ORDER BY 3 ASC LIMIT 25;");
			 $query->bindValue(1, $wantedtime);
			 $query->execute();

			 return $query->fetchAll();
		}

		public function get_bottom10_afterhour($wantedtime) {
			 global $pdo;

			 $query = $pdo->prepare("SELECT songby, songid, AVG(rating), COUNT(rating) FROM ratings WHERE thetime >= ? GROUP BY songid HAVING COUNT(rating) > 2 ORDER BY 3 ASC LIMIT 25;");
			 $query->bindValue(1, $wantedtime);
			 $query->execute();

			 return $query->fetchAll();
		}

		public function get_them_all() {
			 global $pdo;

			 $query = $pdo->prepare("SELECT songby, songid, AVG(rating) FROM ratings GROUP BY songid ORDER BY 3 DESC;");
			 $query->execute();

			 return $query->fetchAll();
		}

		public function get_all_ratings_2($wantedsong) {
			 global $pdo;

			 $query = $pdo->prepare("SELECT author, rating FROM ratings where songid = ? ORDER BY 1;");
			 $query->bindValue(1, $wantedsong);
			 $query->execute();

			 return $query->fetchAll();
		}

		public function past_top10($wantedtime, $lastweek) {
			 global $pdo;

			 $query = $pdo->prepare("SELECT songby, songid, AVG(rating) FROM ratings WHERE thetime <= ? AND thetime > ? GROUP BY songid ORDER BY 3 DESC LIMIT 10;");
			 $query->bindValue(1, $wantedtime);
			 $query->bindValue(2, $lastweek);
			 $query->execute();

			 return $query->fetchAll();
		}

		public function past_top10_afterhour($wantedtime, $lastweek) {
			 global $pdo;

			 $query = $pdo->prepare("SELECT songby, songid, COUNT(rating), AVG(rating) FROM ratings WHERE thetime <= ? AND thetime > ? GROUP BY songid HAVING COUNT(rating) > 2 ORDER BY 4 DESC LIMIT 10;");
			 $query->bindValue(1, $wantedtime);
			 $query->bindValue(2, $lastweek);
			 $query->execute();

			 return $query->fetchAll();
		}


}

?>
