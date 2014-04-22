# hello ruby world
# 
# Author::    Dominik Wlazlowski (mailto:dominik-w@dominik-w.pl)
# Copyright:: Copyright (c) 2010 Dominik Wlazlowski
# License::   Distributes under the same terms as Ruby

# require 'profile'

puts "Hello Ruby World!"

##
BEGIN {
  puts 'Start'
}

END {
  puts 'Stop'
}
##

# methods - def
def say_goodnight(name)
  # result = "Goodnight " + name
  result = "Goodnight #{name}"
  return result
end

puts say_goodnight("Matz")

# variables
$greeting = 'Hi'    # zmienna globalna
@name = 'Matz'      # zmienna egzemplarza
puts "#$greeting, #@name"

3.times { puts "Ruby is cool" }

# text

puts "  aaa  ".strip

puts " I like you     much".squeeze # zamień wielokrotne spacje na pojedyncze

puts "apple banna orange".split # podziel na osobne wyrazy

=begin
comment
=end

# require 'rubygems'
require 'active_support/inflector'

puts "man".pluralize

# oop

# simple class
class Man
  attr_reader :name, :age
  def initialize (name, age)
    @name, @age = name, age
  end
end

man = Man.new("Tom", 20)
puts man
puts man.inspect

puts "\n"

# arrays
a = [ 1, 'test', 3.14, 7 ]
puts a[2]
a[2] = nil
# puts a.to_s
puts a.join(':')

a = %w{ ruby python perl java }
puts a[0]

sekcje = {
  'programowanie' => 'dominik-w',
  'marketing'     => 'jan-x'
}
puts sekcje['programowanie']

tab = Hash.new(-1)
tab[0] = 5
puts tab[0]
puts tab[1]

slowa = ['fiolek', 'roza', 'bez']
puts sekret = slowa[rand(3)]

# modyfikatory
square = 2
puts square = square * square while square < 100

#input
=begin
while line = gets
  puts line.downcase
end
=end

for num in (1..20)
  print num
  print ' '
end

puts

kolekcja = 1..10
kolekcja.each {|element|
  print element
  print ' '
}

def silnia(n)
  if n == 0
    1
  else
    n * silnia(n-1)
  end
end
puts "\n"
puts silnia(5)
# puts silnia(ARGV[0].to_i)

puts ARGV.to_s

warzywo = "pietruszka"
puts warzywo[0, 1]    # "p"
puts warzywo[-2, 2]   # "ka"
puts warzywo[0..3]    # "piet"
puts warzywo[-5..-2]  # "uszk"

# regexp
str = "fLaaga"
if str =~ /f[A-Z][^a-z]*/
  puts "Pasuje"
end

line = 'Perl is cool'
puts line.sub(/Perl/, 'Ruby')

=begin
def show_regexp(a, re)
  if a =~ re
    "#{$`}<<#{$&}>>#{$'}"
  else
    "brak dopasowania"
  end
end
=end

# domkniecia i yield
def powtorz(ilosc)
  while ilosc > 0
    yield # tu przekazujemy sterowanie do domkniecia
    ilosc -= 1
  end
end

powtorz(3) { print "Bla" }
puts

# yield
def call_block
  puts "Begin"
  yield
  yield
  puts "End"
end

call_block { puts "In the block" }

def run
  yield 2, 2
  yield 3, 4
end
run { | x, y | puts x + y }

# lambda
hej = lambda { print "Hej!\n" }

witaj = proc do
  puts "Witaj!"
end

# wywolanie wygląda tak
hej.call
witaj.call

# lambda vs Proc.new
def proc1
  p = Proc.new { return -1 }
  p.call
  puts "Not displayed"
end

def proc2
  p = lambda { return -1 }
  puts "Block returns #{p.call}"
end

proc1
proc2

# iterators
"abc".each_byte { |c| printf "<%c>", c }
#=> <a><b><c>

puts

puts [1, 2, 5].all? { |element| element <= 5 } # => true
# puts [1, 2, 5, 6].all? { |element| element <= 5 } # => false

puts %w{android symbian iphone}.collect { |element| element.upcase }

puts %q/Ciagle 'cytowanie' jest 'bardzo' zmudne/

puts %Q!Ale "w" Ruby'm "bardzo" latwe!

class Song
  def initialize(name, artist, duration)
    @name = name
    @artist = artist
    @duration = duration
  end

  def to_s
    "Song: #@name - #@artist (#@duration) sec"
  end
end

song = Song.new("Song1", "Someone", 240)
puts song.inspect # korzysta z to_s

# dziedziczenie
class KaraokeSong < Song
  @@plays = 0 # zmienna klasy
  attr_reader :name, :artist, :duration
  attr_writer :name, :duration
  def initialize(name, artist, duration, lyrics)
    super(name, artist, duration)
    @lyrics = lyrics
    @plays = 0
  end

  def play
    @plays += 1
    @@plays += 1
    puts "Aktualny utwor: #{@plays} odegran. Calkowita liczba odegran #{@@plays}"
  end

  #def to_s
  #  "Song: #@name - #@artist (#@duration) sec | #{@lyrics}"
  #end

  def to_s
    super + " #@lyrics"
  end
end

ks = KaraokeSong.new("Song1", "Someone", 240, "Yeah yeah...")
puts ks.to_s

ks.name = 'Changed'
puts ks.name

ks.play

ks2 = KaraokeSong.new("Song2", "Someone2", 200, "Yeah2 yeah2...")
ks2.play
ks2.play

# metody klasy

class SongList
  MAX_TIME = 5*60           #  5 minut

  def SongList.is_too_long(song)
    return song.duration > MAX_TIME
  end
end

song1 = KaraokeSong.new("Bicylops", "Fleck", 260, 'Aaaa')
puts SongList.is_too_long(song1)
song2 = KaraokeSong.new("The Calling", "Santana", 468, 'Bbbb')
puts SongList.is_too_long(song2)

require './MyLogger.rb'

puts MyLogger.create.object_id
puts MyLogger.create.object_id

# fibonacci
def fib_up_to(max)
  i1, i2 = 1, 1        # parallel assignment (i1 = 1 and i2 = 1)
  while i1 <= max
    yield i1
    i1, i2 = i2, i1 + i2
  end
end

fib_up_to(1000) {|f| print f, " " }
puts

puts 'A'.succ

=begin
f = File.open(__FILE__)
f.each do |line|
  puts line
end
f.close

require 'open-uri'
open('http://www.ii.uni.wroc.pl') do |fh|
  fh.each_line { |line|  puts line }
end

=end

puts [1,3,5,7].inject(0) {|sum, element| sum + element} # 16

# puts 3.14.methods

# watki / threads
# wyscig watkow
threads = [ ]
5.times do |num|
  threads << Thread.new(num) do |n|
    dystans = 42196
    dystans -= 1 while dystans > 0
    puts "#{n} Stop!"
  end
end

puts threads.each { |t| t.join }

puts

class Counter
  attr_reader :count
  def initialize
    @count = 0
    super
  end
  def tick
    @count += 1
  end
end

c = Counter.new

t1 = Thread.new { 10000.times {  c.tick } }
t2 = Thread.new { 10000.times {  c.tick } }

t1.join
t2.join

puts c.count

puts

some_file = DATA
some_file.each do |line|
  v1, v2 = line.split
  print Integer(v1) + Integer(v2), " "
end
puts
__END__
3 4
5 6
7 8
