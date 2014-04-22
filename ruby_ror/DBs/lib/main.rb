# working with databases; data durability 

require 'yaml'

puts str = YAML.dump([1, 'dwa', 3.0])
lista = YAML.load(str)
puts lista

puts [100, "test", 900].to_yaml

# dbm
require 'dbm'

# save
DBM.open('baza') do |db|
  db['klucz'] = 'wartosc'
  puts db['klucz']
end

# read
DBM.open('baza') do |db|
  db.each { |k, v| puts " #{k} => #{v}" }
end

# sql db

require 'dbi'

# db = DBI.connect("DBI:SQLite:test.db")

# DBI.connect("DBI:Mysql:test:localhost", "testuser", "testpass")

=begin
'CREATE TABLE studs (
id INT(11) NOT NULL AUTO_INCREMENT,
index VARCHAR (20),
punkty INT,
PRIMARY KEY(id))'

'CREATE TABLE stud_exercises (
id INT NOT NULL AUTO_INCREMENT,
stud_id INT(11),
zad INT,
tresc TEXT,
PRIMARY KEY(id))'

require 'activerecord'
class Stud < ActiveRecord::Base
  has_many :stud_exercises
end
class StudExercise < ActiveRecord::Base
  belongs_to :stud
end
=end

dbh = DBI.connect("DBI:Mysql:dw_core_rb:localhost", "user", "haslo")


