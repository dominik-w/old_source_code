-- tests
--[[
 - test 1
 - test 2
]]

print("Lua tests")

for i = 1,5 do
  -- print("Test")
  -- print(string.format('Test %q', i))
  print('Test ' .. i)
end

-- print("10" + 1)             --> 11
-- print(1 + "10")             --> 11
-- print("some string" + 1)    --> Error

-- Factorial
-- @param n
function factorial(n)
  if n == 0 then
    return 1
  else
    return n * factorial(n - 1)
  end
end

print(factorial(10))

-- meta
fibs = { 1, 1 }                          -- Initial values for fibs[1] and fibs[2].
setmetatable(fibs, {
  __index = function(name, n)           -- Call this function if fibs[n] does not exist.
    name[n] = name[n - 1] + name[n - 2]  -- Calculate and memoize fibs[n].
    return name[n]
  end
})

a_table = {x = 10}  -- Creates a new table, with one entry mapping "x" to the number 10
print(a_table["x"])


-- oop

Vector = {}                    -- Create a table to hold the class methods
function Vector:new(x, y, z)  -- The constructor
  local object = { x = x, y = y, z = z }
  setmetatable(object, { __index = Vector })  -- Inheritance
  return object
end
function Vector:magnitude()   -- Another member function
  -- Reference the implicit object using self
  return math.sqrt(self.x^2 + self.y^2 + self.z^2)
end

vec = Vector:new(0, 1, 0)     -- Create a vector
print(vec:magnitude())        -- Call a member function using ":" (output: 1)
print(vec.x)                  -- Access a member variable using "." (output: 0)

-- print(loadfile("hello.lua"))

local str = string.format('%q', 'a string with "quotes" and \n new line')
print(str)

local _c = os.clock()
local _d = os.date()

print(_c)
print("")
print(_d)

print("\n")
print(os.date("today is %A, in %B"))


a = "This is a string"

-- multiline
b = [[
This is a long string. That can span
multiple lines and include
\[\[escaped double brackets\]\]
too.
]]

print(b)


k = 100
for i = 100, (k - 100), -10 do
  k = k - 10;
  print("i: " .. i .. " k: " .. k);
end

-- generic
q = {
  ["fruit"] = "banana",
  ["animal"] = "tiger"
}

for k,v in pairs(q) do
  print("k:" .. k .. " v: " .. v);
end

print()

days = {"Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"}

for k,v in pairs(days) do
    print("k:" .. k .. " v: " .. v);
end

-- va args
function connect(...)
    local connected = ""

    for i = 1, table.getn(arg) do
        connected = connected .. " " .. arg[i]
    end

    return connected
end

connected = connect("this", "that")

print(connected)    -->  this that


-- Closeures
cities = {"Mumbai", "Delhi", "Chennai", "Kolkata"}

table.sort(cities, function(n1, n2)
    return n1 < n2
end)

for i = 1, table.getn(cities) do
    print(cities[i])
end


printResult = ""

function print (...)
  for i,v in ipairs(arg) do
    printResult = printResult .. tostring(v) .. "\t"
  end
  printResult = printResult .. "\n"
end


