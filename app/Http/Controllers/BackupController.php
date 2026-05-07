<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BackupController extends Controller
{
    public function index()
    {
        return view('backup.index');
    }

    public function download()
    {
        $tables = DB::select('SHOW TABLES');
        $dbName = env('DB_DATABASE', 'simaset');
        $tablesKey = "Tables_in_" . $dbName;

        $sqlDump = "-- SIMASET Database Backup\n";
        $sqlDump .= "-- Generated on: " . date('Y-m-d H:i:s') . "\n\n";
        $sqlDump .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

        foreach ($tables as $tableRow) {
            $table = $tableRow->$tablesKey;

            // 1. Drop statement
            $sqlDump .= "DROP TABLE IF EXISTS `" . $table . "`;\n";

            // 2. Create statement
            $createTable = DB::select("SHOW CREATE TABLE `" . $table . "`");
            $sqlDump .= $createTable[0]->{'Create Table'} . ";\n\n";

            // 3. Insert statements
            $rows = DB::select("SELECT * FROM `" . $table . "`");
            if (count($rows) > 0) {
                foreach ($rows as $row) {
                    $keys = array_keys((array)$row);
                    $values = array_values((array)$row);

                    $escapedValues = array_map(function ($value) {
                        if ($value === null) return 'NULL';
                        return "'" . addslashes($value) . "'";
                    }, $values);

                    $sqlDump .= "INSERT INTO `" . $table . "` (`" . implode("`, `", $keys) . "`) VALUES (" . implode(", ", $escapedValues) . ");\n";
                }
                $sqlDump .= "\n";
            }
        }

        $sqlDump .= "SET FOREIGN_KEY_CHECKS=1;\n";

        $filename = 'backup_simaset_' . date('Y-m-d_H-i-s') . '.sql';

        return response($sqlDump)
            ->header('Content-Type', 'application/sql')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    public function restore(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|file|max:20480' // max 20MB
        ]);

        $file = $request->file('backup_file');
        $sqlContent = file_get_contents($file->getRealPath());

        try {
            DB::beginTransaction();
            // DB::unprepared can run multiple statements separated by ;
            DB::unprepared($sqlContent);
            DB::commit();

            return back()->with('success', 'Database berhasil dipulihkan dari file cadangan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memulihkan database: ' . $e->getMessage());
        }
    }

    public function deleteKibData(Request $request)
    {
        $request->validate([
            'kib_type' => 'required|in:A,B,C,D,E,F'
        ]);

        try {
            $deletedCount = Aset::where('kib_type', $request->kib_type)->delete();
            return back()->with('success', 'Berhasil menghapus ' . $deletedCount . ' data aset KIB ' . $request->kib_type . '.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
