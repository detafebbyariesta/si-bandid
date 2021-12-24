<?php

$page = $_GET["page"];
$action = $_GET["action"];

if ($page == "rpjmdes") {
  if ($action == '') {
    include "page/perencanaan/rpjmdes/rpjmdes.php";
  } elseif ($action == "delete") {
    include "page/perencanaan/rpjmdes/delete.php";
  }
} elseif ($page == "rkpdes") {
  if ($action == '') {
    include "page/perencanaan/rkpdes/rkpdes.php";
  } elseif ($action == "delete") {
    include "page/perencanaan/rkpdes/delete.php";
  }
 } elseif ($page == "apbdes") {
  if ($action == '') {
    include "page/perencanaan/apbdes/apbdes.php";
  } elseif ($action == "delete") {
    include "page/perencanaan/apbdes/delete.php";
  }
 } elseif ($page == "apbdes_perub") {
  if ($action == '') {
    include "page/perencanaan/apbdes_perub/apbdes_perub.php";
  } elseif ($action == "delete") {
    include "page/perencanaan/apbdes_perub/delete.php";
  }
 } elseif ($page == "rpd") {
  if ($action == '') {
    include "page/pelaksanaan/rpd/rpd.php";
  } elseif ($action == "delete") {
    include "page/pelaksanaan/rpd/delete.php";
  }
 } elseif ($page == "p_apbdes") {
  if ($action == '') {
    include "page/pelaksanaan/apbdes/p_apbdes.php";
  } elseif ($action == "delete") {
    include "page/pelaksanaan/apbdes/delete.php";
  }
 } elseif ($page == "p_dd") {
  if ($action == '') {
    include "page/pelaksanaan/dd/p_dd.php";
  } elseif ($action == "delete") {
    include "page/pelaksanaan/dd/delete.php";
  }
 } elseif ($page == "p_add") {
  if ($action == '') {
    include "page/pelaksanaan/add/p_add.php";
  } elseif ($action == "delete") {
    include "page/pelaksanaan/add/delete.php";
  }
 } elseif ($page == "p_pad") {
  if ($action == '') {
    include "page/pelaksanaan/pad/p_pad.php";
  } elseif ($action == "delete") {
    include "page/pelaksanaan/pad/delete.php";
  }
 } elseif ($page == "retribusi") {
  if ($action == '') {
    include "page/pelaksanaan/retribusi/retribusi.php";
  } elseif ($action == "delete") {
    include "page/pelaksanaan/retribusi/delete.php";
  }
 } elseif ($page == "sk") {
  if ($action == '') {
    include "page/pelaksanaan/sk/sk.php";
  } elseif ($action == "delete") {
    include "page/pelaksanaan/sk/delete.php";
  }
 } elseif ($page == "bulanan") {
  if ($action == '') {
    include "page/pelaporan/bulanan/bulanan.php";
  } elseif ($action == "delete") {
    include "page/pelaporan/bulanan/delete.php";
  }
 } elseif ($page == "smt1") {
  if ($action == '') {
    include "page/pelaporan/semester_1/smt_1.php";
  } elseif ($action == "delete") {
    include "page/pelaporan/semester_1/delete.php";
  }
 } elseif ($page == "smt2") {
  if ($action == '') {
    include "page/pelaporan/semester_2/smt_2.php";
  } elseif ($action == "delete") {
    include "page/pelaporan/semester_2/delete.php";
  }
 } elseif ($page == "lppd") {
  if ($action == '') {
    include "page/pelaporan/lppd/lppd.php";
  } elseif ($action == "delete") {
    include "page/pelaporan/lppd/delete.php";
  }
 } elseif ($page == "ippd") {
  if ($action == '') {
    include "page/pelaporan/ippd/ippd.php";
  } elseif ($action == "delete") {
    include "page/pelaporan/ippd/delete.php";
  }
 } elseif ($page == "lkpj") {
  if ($action == '') {
    include "page/pelaporan/lkpj/lkpj.php";
  } elseif ($action == "delete") {
    include "page/pelaporan/lkpj/delete.php";
  }
 } elseif ($page == "omspan") {
  if ($action == '') {
    include "page/pelaporan/omspan/omspan.php";
  } elseif ($action == "delete") {
    include "page/pelaporan/omspan/delete.php";
  }
 } elseif ($page == "tanggungjawab") {
  if ($action == '') {
    include "page/pelaporan/tanggungjawab/tanggungjawab.php";
  } elseif ($action == "delete") {
    include "page/pelaporan/tanggungjawab/delete.php";
  }
 } elseif ($page == "ba_kas") {
  if ($action == '') {
    include "page/pelaporan/ba_kas/ba_kas.php";
  } elseif ($action == "delete") {
    include "page/pelaporan/ba_kas/delete.php";
  }
 } elseif ($page == "habis_pakai") {
  if ($action == '') {
    include "page/pelaporan/habis_pakai/habis_pakai.php";
  } elseif ($action == "delete") {
    include "page/pelaporan/habis_pakai/delete.php";
  }
 } elseif ($page == "rekap_apbdes") {
  if ($action == '') {
    include "page/pelaporan/rekap_apbdes/rekap_apbdes.php";
  } elseif ($action == "delete") {
    include "page/pelaporan/rekap_apbdes/delete.php";
  }
 } elseif ($page == "rekap_sumberdana") {
  if ($action == '') {
    include "page/pelaporan/rekap_sumberdana/rekap_sumberdana.php";
  } elseif ($action == "delete") {
    include "page/pelaporan/rekap_sumberdana/delete.php";
  }
 } elseif ($page == "register_kas") {
  if ($action == '') {
    include "page/pelaporan/register_kas/register_kas.php";
  } elseif ($action == "delete") {
    include "page/pelaporan/register_kas/delete.php";
  }
 } elseif ($page == "lain_lain") {
  if ($action == '') {
    include "page/pelaporan/lain_lain/lain_lain.php";
  } elseif ($action == "delete") {
    include "page/pelaporan/lain_lain/delete.php";
  }
 } elseif ($page == "profile") {
  if ($action == '') {
    include "page/setting/profile.php";
  }
 } elseif ($page == "ganti_pass") {
  if ($action == '') {
    include "page/setting/ganti_pass.php";
  }
 } elseif ($page == "backup") {
  if ($action == '') {
    include "page/setting/backup.php";
  }
 } elseif ($page == "user") {
  if ($action == '') {
    include "page/setting/user.php";
  }
 } elseif ($page == "") {
  include "dashboard.php";
}
