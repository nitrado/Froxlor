-- 2013-03-05 (aaron)
-- Add the allow_external_access field to the database table to save the state
-- of the host setting (%), see ticket #814;
ALTER TABLE froxlor.panel_databases ADD allow_external_access INT(1) DEFAULT 0;

