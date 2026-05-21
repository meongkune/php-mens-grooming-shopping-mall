<?
include "common.php";

$cart = isset($_COOKIE["cart"]) && is_array($_COOKIE["cart"]) ? $_COOKIE["cart"] : array();
$n_cart = isset($_COOKIE["n_cart"]) ? (int)$_COOKIE["n_cart"] : 0;
$kind = $_REQUEST["kind"] ?? "";
$pos = isset($_REQUEST["pos"]) ? (int)$_REQUEST["pos"] : 0;

function save_cart_cookie($key, $value)
{
    setcookie("cart[$key]", $value, 0, "/");
    setcookie("cart[$key]", $value);
}

function delete_cart_cookie($key)
{
    setcookie("cart[$key]", "", time() - 3600, "/");
    setcookie("cart[$key]", "", time() - 3600);
}

switch ($kind) {
case "insert":
case "order":
    $id = (int)($_REQUEST["id"] ?? 0);
    $num = max(1, (int)($_REQUEST["num"] ?? 1));
    $opts_id1 = $_REQUEST["opts1"] ?? 0;
    $opts_id2 = $_REQUEST["opts2"] ?? 0;
    $extra_price = (int)($_REQUEST["extra_price"] ?? 0);

    if ($opts_id1 === "" || $opts_id1 === "none") $opts_id1 = 0;
    if ($opts_id2 === "" || $opts_id2 === "none") $opts_id2 = 0;

    $n_cart++;
    $cart[$n_cart] = implode("^", array($id, $num, (int)$opts_id1, (int)$opts_id2, $extra_price));
    save_cart_cookie($n_cart, $cart[$n_cart]);
    setcookie("n_cart", $n_cart, 0, "/");
    setcookie("n_cart", $n_cart);
    break;

case "delete":
    if ($pos > 0) {
        delete_cart_cookie($pos);
        unset($cart[$pos]);
    }
    break;

case "update":
    if ($pos > 0 && isset($cart[$pos])) {
        list($id, $old_num, $opts_id1, $opts_id2, $extra_price) = array_pad(explode("^", $cart[$pos]), 5, 0);
        $num = max(1, (int)($_REQUEST["num"] ?? $old_num));
        $cart[$pos] = implode("^", array((int)$id, $num, (int)$opts_id1, (int)$opts_id2, (int)$extra_price));
        save_cart_cookie($pos, $cart[$pos]);
    }
    break;

case "deleteall":
    for ($i = 1; $i <= $n_cart; $i++) {
        delete_cart_cookie($i);
    }
    $n_cart = 0;
    setcookie("n_cart", "0", time() - 3600, "/");
    setcookie("n_cart", "0", time() - 3600);
    break;
}

if ($kind == "order")
    echo("<script>location.href='order.php'</script>");
else
    echo("<script>location.href='cart.php'</script>");
?>
