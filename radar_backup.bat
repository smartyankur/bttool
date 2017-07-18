
set dbuser=root
set dbpass=password
set errorLogPath="G:\BTTool2\dumperrors.txt"
set mysqldumpexe="C:\Program Files\MySQL\MySQL Server 5.5\bin\mysqldump.exe"
set backupfile=G:\BTTool2\db\radar_db_backup
::set backupfile_app=F:\SVNBackups\Bttool\bttool_app_backup
set backupfldr=G:\BTTool2\
set datafldr="C:\Documents and Settings\All Users\Application Data\MySQL\MySQL Server 5.5\data"
set zipper="F:\SVNBackups\MySQLBackups\zip\7za.exe"
set svntool="C:\Program Files\TortoiseSVN\bin\svn.exe"
set retaindays=30
::pushd %datafldr%

@echo off

echo "Creating database backup"
%mysqldumpexe% --user=%dbuser% --password=%dbpass% --databases bttool17jan17 --routines --log-error=%errorLogPath%  > "%backupfile%.sql"

echo "Changing folder to G:\BTTool2\db\"
pushd G:\BTTool2\db\

echo "Adding unversioned files to SVN in DB Folder"
%svntool% --force --depth infinity add .

echo "Changing folder to G:\BTTool2\web\"
pushd G:\BTTool2\web\

echo "Adding unversioned files to SVN in WEB Folder"
%svntool% --force --depth infinity add .

echo "Changing folder to G:\BTTool2\"
pushd G:\BTTool2\

echo "Committing files in SVN for g:\BTTool2\"
%svntool% ci -m "'


::pushd %backupfldr%

:: echo "Zipping all files ending in .sql in the folder"

:: %zipper% a -tzip "%backupfile%.zip" "%backupfile%.sql"

:: Copying the backup at a network location.
::xcopy "%backupfile%FullBackup.%backuptime%.zip" "\\rmserver-1\Test\"
::echo "Deleting all the files ending in .sql only"
::del "%backupfile%.sql"

::pushd %backupfldr%
::echo "committing db backup into svn repository"
::%svntool% commit -m "LogMessage" [--no-unlock] "%backupfile%.sql"

::echo "Zipping all application files"
::%zipper% a -tzip -r "%backupfile_app%.zip" "G:\BTTool"

::return to the main script dir on end
popd