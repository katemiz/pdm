#!/bin/sh
# Laravel App Ownership Script

sudo chown -R www-data:www-data /www/PDM
sudo chmod -R 755 /www/PDM/storage
sudo chmod -R 755 /www/PDM/bootstrap/cache
sudo chmod 600 /www/PDM/.env


sudo chown -R www-data:www-data /STORAGE


# Bu tablodan tabloya taşımak için
INSERT INTO items (id,user_id,updated_uid,part_type,part_number,part_number_mt,part_number_wb,version,is_latest,vendor,vendor_part_no,description,url,weight,material_text,finish_text,remarks,status,created_at,updated_at   )
SELECT id,user_id,updated_uid,'Buyable',part_number,part_number_mt,part_number_wb,version,is_latest,vendor,vendor_part_no,description,url,weight,material,finish,notes,status,created_at,updated_at
FROM buyables



INSERT INTO items (id,updated_uid,part_type,user_id,part_number,part_number_mt,part_number_wb,version,is_latest,vendor,vendor_part_no,description,url,weight,material_text,finish_text,remarks,status,created_at,updated_at   )
SELECT id,user_id,updated_uid,'Detail-Make',part_number,part_number_mt,part_number_wb,version,is_latest,vendor,vendor_part_no,description,url,weight,material,finish,notes,status,created_at,updated_at
FROM buyables
