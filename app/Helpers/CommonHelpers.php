<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class CommonHelpers
{
    const DATA_SUCCESS = "Data fetch successfully!";
    const DATA_NOT_FOUND = "No data found!";
    const DATA_UPDATED = "Data Executed!";
    const DATA_DELETED = "Data Deleted!";
    const NOT_ALLOWED = "You are not allowed!";
    const OTP_VERIFIED = "OTP Verified!";
    const OTP_ALREADY_VERIFIED = "OTP Already Verified!";
    const OTP_NOT_VERIFY = "OTP is invalid!";
    const ADMINTYPE = 1;
    const USERTYPE = 2;
    const ACTVEPROFILE = 1;
    const INACTVEPROFILE = 2;
    const UNVERIFYPROFILE = 3;
    const BLOCKPROFILE = 4;
    const DELETEPROFILE = 5;
    const ACTIVESTATUS = 1;
    const PENDINGSTATUS = 2;
    const REJECTSTATUS = 3;
    const DELETESTATUS = 4;
    const CANCELSTATUS = 5;
    const APPLICATIONRECEIVED = 5;
    const SUBMITTED = 'SU';
    const FORWARDED = 'UP';
    const IN_QUERY = 'QU';
    const QUERY_RESOLVE = 'QR';
    const SITE_INPECTION_SCHEDULED = 'IN';
    const INSPECTION_REPORT_SUBMITTED = 'IR';
    const APPROVED = 'AP';
    const TDRC_ISSUED = 'CI';
    const DEED_RECEIVED = 'DR';
    const REJECTED = 'RJ';
    const TDR_UPDATE = 'TU';
    const AWAITING_BUILDING_PERMISSION_PRE_APPROVAL = 'AW';
    const BUILDING_PERMISSION_PRE_APPROVED = 'BP';
    const ISSUED = 'IS';
    const TRANSFERRED = 'TR';
    const UTILIZED = 'UT';
    const FROZEN = 'FR';
    const UNFROZEN = 'UF';
    const APPLIED_FOR = 'AF';
    const PRE_APPROVED = 'PA';
    const APPLICATION_APPROVED = 'AA';
    const APPLICATION_REJECTED = 'AR';
}
