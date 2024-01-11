<?php

class Category
{
	# prywatne wartości klasy
	private $id;
	private $matka;
	private $nazwa;

	# do sprawdzenia czy zostały wprowadzone zmiany w obiekcie
	private $hash;

	public function __construct() # o tutaj sprawdzenie
	{
		$this->hash = $this->getHash();
	}

	function add() # funkcja korzystająca z zapytania SQL dodającego wartości do tabeli categories
	{
		return 'INSERT INTO categories (nazwa, matka) VALUES (\'' .$this->nazwa. '\',' .$this->matka. ')';
	}

	function edit() # funkcja korzystająca z zapytania SQL edytującego wartości z tabeli categories
	{
		return 'UPDATE categories SET nazwa=\'' .$this->nazwa. '\', matka=' .$this->matka. ' WHERE id=' .$this->id;
	}

	function delete() # funkcja korzystająca z zapytania SQL usuwającego wartości z tabeli categories
	{
		return 'DELETE FROM categories WHERE id=' .$this->id;
	}

	# Gettery i Settery

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param mixed $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @return mixed
	 */
	public function getMatka()
	{
		return $this->matka;
	}

	/**
	 * @param mixed $matka
	 */
	public function setMatka($matka)
	{
		$this->matka = $matka;
	}

	/**
	 * @return mixed
	 */
	public function getCategoryName()
	{
		return $this->nazwa;
	}

	/**
	 * @param mixed $nazwa
	 */
	public function setCategoryName($nazwa)
	{
		$this->nazwa = $nazwa;
	}

	private function getHash()
	{
		$sum = (string)$this->id . (string)$this->matka . $this->nazwa;
		return hash("sha512", $sum);
	}

	# Sprawdza czy zostały zrobione zmiany w obiekcie po utworzeniu
	public function changed(){
		if(empty($this->id)){
			return false; # brak w bazie
		} else {
			if($this->hash !== $this->getHash()){
				return true;
			}
			return false;
		}
	}

}