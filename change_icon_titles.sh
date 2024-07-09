#!/bin/sh

sed -i 's/<title>edit<\/title>/<title>Edit Item<\/title>/g' ./vendor/codeat3/blade-carbon-icons/resources/svg/edit.svg
sed -i 's/<title>trash-can<\/title>/<title>Delete Item<\/title>/g' ./vendor/codeat3/blade-carbon-icons/resources/svg/trash-can.svg
sed -i 's/<title>send<\/title>/<title>Release Item<\/title>/g' ./vendor/codeat3/blade-carbon-icons/resources/svg/send.svg
sed -i 's/<title>stamp<\/title>/<title>Freeze Item<\/title>/g' ./vendor/codeat3/blade-carbon-icons/resources/svg/stamp.svg
sed -i 's/<title>document--pdf<\/title>/<title>Convert to PDF<\/title>/g' ./vendor/codeat3/blade-carbon-icons/resources/svg/document-pdf.svg
sed -i 's/<defs><\/defs>/<defs><\/defs><title>Parts with Material<\/title>/g' ./vendor/codeat3/blade-carbon-icons/resources/svg/connect-reference.svg
sed -i 's/<defs><\/defs>/<defs><\/defs><title>Replicate<\/title>/g' ./vendor/codeat3/blade-carbon-icons/resources/svg/replicate.svg
sed -i 's/<defs><\/defs>/<defs><\/defs><title>Mirror Part<\/title>/g' ./vendor/codeat3/blade-carbon-icons/resources/svg/crossroads.svg