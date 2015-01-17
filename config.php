<?php
//phpdhcpd config file

//Location of dhcpd.leases file
$dhcpd_leases_file = "/var/lib/dhcp/dhcpd.leases";

//Run MAC address vendor check
//Note: this can be taxing on systems with a large leases file
$mac_vendor = true;

//Save MAC vendor hits to cache file
//If this is enabled, it will search this smaller file first for the vendor.
//If it's not found, it then switches over to the main larger file.  The
//purpose of this is for extremely large lease files, this speeds up
//the lookup time considerably.  It writes to the cache file any results
//that it finds.
$cache_vendor_results = true;


//phpdhcpd version
//You don't have to change this
$version = "0.7";
?>
