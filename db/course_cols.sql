UPDATE grade_level SET course = 1;
ALTER TABLE grade_level
ADD COLUMN course INT NOT NULL AFTER section;