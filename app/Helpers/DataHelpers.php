<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class DataHelpers
{
    public static function addData($modal, $data)
    {
        $add = $modal::insert($data);
        if ($add) {
            return true;
        } else {
            return false;
        }
    }

    public static function addDataGetId($modal, $data)
    {
        $add = $modal::insertGetId($data);
        if ($add) {
            return $add;
        } else {
            return false;
        }
    }
    public static function addUpdate($modal, $where, $id, $data)
    {
        $add = $modal::where($where, $id)->update($data);
        if ($add) {
            return true;
        } else {
            return false;
        }
    }
    public static function updateOrInsert($modal, $where, $id, $data)
    {
        $add = $modal::updateOrCreate([$where => $id], $data);
        if ($add) {
            return $add;
        } else {
            return false;
        }
    }
    public static function getAllData($modal, $with = [], $order = "created_at", $by = "ASC")
    {
        $get = $modal::with($with)->orderBy($order, $by)->get();
        if ($get) {
            return $get;
        } else {
            return false;
        }
    }
    public static function getAllDataWithPage($modal, $with = [], $count, $order = "created_at", $by = "ASC")
    {
        $get = $modal::with($with)->orderBy($order, $by)->paginate($count);
        if ($get) {
            return $get;
        } else {
            return false;
        }
    }
    public static function getDataWithPageById($modal, $with = [], $count, $where, $id, $order = "created_at", $by = "ASC")
    {
        $get = $modal::with($with)->where($where, $id)->orderBy($order, $by)->paginate($count);
        if ($get) {
            return $get;
        } else {
            return false;
        }
    }
    public static function getAllDataById($modal, $where, $id, $order = "created_at", $by = "ASC", $limit = 100000, $with = [])
    {
        $get = $modal::with($with)->where($where, $id)->orderBy($order, $by)->get();
        if ($get) {
            return $get;
        } else {
            return false;
        }
    }
    public static function getSingleData($modal, $where, $id, $with = [])
    {
        $get = $modal::with($with)->where($where, $id)->first();
        if ($get) {
            return $get;
        } else {
            return false;
        }
    }
    public static function getSelectedSingleData($modal, $with, $select = '*', $where, $id)
    {
        $get = $modal::with($with)->select($select)->where($where, $id)->first();
        if ($get) {
            return $get;
        } else {
            return false;
        }
    }

    public static function joinTabledata($table, $jointable, $id, $tableid, $order = "created_at", $ordertype = 'asc', $count = -1)
    {
        $created_at = $table . '.' . $order;
        $get = DB::table($table)->join($jointable, $id, '=', $tableid)->orderBy($created_at, $ordertype)->get()->take($count);
        if ($get) {
            return $get;
        } else {
            return false;
        }
    }

    public static function deleteAllDataById($modal, $where, $id)
    {
        $get = $modal::where($where, $id)->delete();
        if ($get) {
            return true;
        } else {
            return false;
        }
    }
    public static function singlefile($request)
    {
        if (!empty($request)) {
            $file = str_replace(' ', '-', $request->getClientOriginalName());
            $name = time() . '_' . $file;
            return $name;
        }
    }

    public static function multiplefiles($files)
    {
        $getnames = [];
        foreach ($files as $key => $file) {
            $path = str_replace(' ', '-', $file->getClientOriginalName());
            $name = rand(1111, 9999) . '_' . time() . '_' . $path;
            array_push($getnames, $name);
        }
        return $getnames;
    }

    public static function multiplefilesWithKey($files)
    {
        $getnames = [];
        foreach ($files as $key => $file) {
            if ($file != null) {
                $path = str_replace(' ', '-', $file->getClientOriginalName());
                $name = rand(1111, 9999) . '_' . time() . '_' . $path;
                $getnames += [$key => $name];
            }
        }
        return $getnames;
    }

    public static function validation($valdiate)
    {
        if ($valdiate->fails()) {
            return response()->json(['status' => false, 'data' => null, 'message' => $valdiate->getMessageBag()], 422);
        }
    }

    public static function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function responseMessage($save, $message, $url, $data = [])
    {
        if ($save) {
            return response()->json(['status' => true, 'data' => $data, 'message' => $message, 'url' => $url]);
        } else {
            if (!empty($message)) {
                return response()->json(['status' => false, 'message' => 'Something went wrong!']);
            } else {
                return response()->json(['status' => false, 'message' => 'Something went wrong!']);
            }
        }
    }
}
