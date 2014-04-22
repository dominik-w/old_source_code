#!/usr/bin/env ruby

# example program
#
# Author::    Dominik Wlazlowski (mailto:dominik-w@dominik-w.pl)
# Copyright:: Copyright (c) 2010 Dominik Wlazlowski
# License::   Distributes under the same terms as Ruby

class MegaGreeter
  attr_accessor :names

  # create the object
  def initialize(names = "World")
    @names = names
  end

  # say hi to everybody
  def say_hi
    if @names.nil?
      puts "..."
    elsif @names.respond_to?("each")
      # @names is a list of some kind, iterate!
      @names.each do |name|
        puts "Hello #{name}!"
      end
    else
      puts "Hello #{@names}!"
    end
  end

  # say bye to everybody
  def say_bye
    if @names.nil?
      puts "..."
    elsif @names.respond_to?("join")
      # join the list elements with commas
      puts "Goodbye #{@names.join(", ")}. Come back soon!"
    else
      puts "Goodbye #{@names}. Come back soon!"
    end
  end

end

if __FILE__ == $0
  mg = MegaGreeter.new
  mg.say_hi
  mg.say_bye

  # zmień imię
  mg.names = "Zxcd"
  mg.say_hi
  mg.say_bye

  # zmień imię na tablicę imion
  mg.names = ["Albert", "Brenda", "Charles", "Dave", "Englebert"]
  mg.say_hi
  mg.say_bye

  # zmień imię na nil
  mg.names = nil
  mg.say_hi
  mg.say_bye
end
