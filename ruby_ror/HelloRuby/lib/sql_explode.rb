# A simple tool to large files SQL partition
#

SQL_FILE = "file.sql"
OUTPUT_PATH = "chunks/"
FACTOR = 1000 # how many lines

line_num = 1
file_num = 0
Dir.mkdir(OUTPUT_PATH) unless File.exists? OUTPUT_PATH
file = File.new(OUTPUT_PATH + "chunk_" + file_num.to_s + ".sql",
    File::CREAT|File::TRUNC|File::RDWR, 0644)
done, seen_1k_lines = false
IO.readlines(SQL_FILE).each do |line|
  file.puts(line)
  seen_1k_lines = (line_num % FACTOR == 0) unless seen_1k_lines
  line_num += 1
  # done = (line.downcase =~ /^\W*go\W*$/ or line.downcase =~ /^\W*end\W*$/) != nil
  done = true
  if done and seen_1k_lines
    file_num += 1
    file = File.new(OUTPUT_PATH + "chunk_" + file_num.to_s + ".sql",
      File::CREAT|File::TRUNC|File::RDWR, 0644)
    done, seen_1k_lines = false
  end
end
