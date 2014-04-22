class BuildDb < ActiveRecord::Migration

  def self.up
    create_table :languages, :force => true do |t|
      t.column :name, :string
      t.column :description, :string
    end
  end

  def self.down
    drop_table :languages
  end
end