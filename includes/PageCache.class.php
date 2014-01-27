<?php
/**
 * Created on 2009-12-10
 * Cache缓存类
 * @author luodong
 * ChengDu CandorSoft Co., Ltd.
 * @version $Id: PageCache.class.php,v 1.1 2012/02/07 08:59:18 gfl Exp $
 */

/* $cache = new Cache("../cache/",20); // 构造函数，创建缓存类对象
   ………………………………
   ………………………………
   ………………………………
   $cache->PutCache();  // 倒出缓存
*/

class Cache
{
    private $CacheDir = "Cache";     /* 缓存目录 */
    private $SetTimeOut = 10;        /* 缓存过期时间 */
    private $SetExt = ".cache";      /* 缓存文件后缀名 */
    private $CacheFileUrl = "";      /* 缓存文件所在地址 */
    private $CacheConfigFile = "";  /* 缓存文件配置信息 */

    public $LastUnixTimePoke = 0;   /* 上一次缓存的 Unix 时间戳 */
    public $CurrentUnixTimePoke = 0;/* 当前缓存的 Unix 时间戳 */
    public $NextUnixTimePoke = 0;   /* 下一次缓存的 Unix 时间戳 */
    public $UnixNowToNext = 0;        /* 现在和下一次缓存相差的 Unix 时间戳 */

    public $LastTimePoke = 0;   /* 上一次缓存的时间 */
    public $CurrentTimePoke = 0;/* 当前缓存的时间 */
    public $NextTimePoke = 0;   /* 下一次缓存的时间 */

    public $DataLength = 0; /* 缓存区内容长度 */
    public $CacheToPage = ""; /* 缓存文件内容 */
    private $SplitTeam = false;  /* 是否分组存放Cache文件 */

    public $Cache = false;        /* 是否需要缓存，用户外界判断 */

    private $_IsCache = false; /* 是否能够缓存 */

    public function Cache($SetTimeOut = 20,$CacheDir = "Cache",$SplitTeam = false,$SetExt = ".cache")
    {
        $this->CacheDir = $CacheDir;
        $this->SplitTeam = $SplitTeam;
        if(!is_numeric($SetTimeOut))
        {
            $this->ErrResponse("缓存过期时间设置无效");
            return false;
        } else {
            $this->SetTimeOut = $SetTimeOut;
        }
        $this->SetExt = $SetExt;

        /* 缓存开始 */
        ob_clean();
        ob_start();
        ob_implicit_flush(0);
        $this->CreateCache();
        return true;
    }

    private function CreateCache()
    {
        $_CacheFile = str_replace(".","_",basename($_SERVER["PHP_SELF"])) . "_" .
                      md5(basename($_SERVER["PHP_SELF"])) . $this->SetExt;
        $_CacheConfig = str_replace(".","_",basename($_SERVER["PHP_SELF"])) . "_" . ".cof";

        if(!file_exists($this->CacheDir))
        {      mkdir($this->CacheDir,0777);
        }

        if($this->SplitTeam)
        {
            $_CacheConfigDir = $this->CacheDir . str_replace(".","_",basename($_SERVER["PHP_SELF"])) . "_/";
            if(!file_exists($_CacheConfigDir))
            {
                mkdir($_CacheConfigDir,0777);
            }
            $_CacheUrl = $this->CacheDir . $_CacheConfigDir . $_CacheFile;
            $_CacheConfigUrl = $this->CacheDir . $_CacheConfigDir . $_CacheConfig;
        } else {
            $_CacheUrl = $this->CacheDir . $_CacheFile;
            $_CacheConfigUrl = $this->CacheDir . $_CacheConfig;
		}

        if(!file_exists($_CacheUrl))
        {
            $hanld = @fopen($_CacheUrl,"w");
            @fclose($hanld);
        }

        if(!file_exists($_CacheConfigUrl))
        {
            $hanld = @fopen($_CacheConfigUrl,"w");
            @fclose($hanld);
        }
		$this->CacheConfigFile = $_CacheConfigUrl;
        $this->CacheFileUrl = $_CacheUrl;
        $this->CheckCache();
        return true;
    }

    private function CheckCache()
    {
        $_FileEditTime = @filemtime($this->CacheFileUrl);
        $_TimeOut = $this->SetTimeOut;
        $_IsTimeOut = $_FileEditTime + $_TimeOut;

        $this->LastUnixTimePoke = $_FileEditTime;
        $this->NextUnixTimePoke = $_IsTimeOut;
        $this->CurrentUnixTimePoke = time();
        $this->UnixNowToNext = $this->NextUnixTimePoke - time();

        $this->LastTimePoke = date("Y-m-d H:i:s",$_FileEditTime);
        $this->NextTimePoke = date("Y-m-d H:i:s",$_IsTimeOut);
        $this->CurrentTimePoke = date("Y-m-d H:i:s",time());

        $_TxtInformation = "上次缓存时间戳: $this->LastUnixTimePoke ";
        $_TxtInformation .= "当前缓存时间戳: $this->CurrentUnixTimePoke ";
        $_TxtInformation .= "下次缓存时间戳: $this->NextUnixTimePoke ";

        $_TxtInformation .= "上次缓存时间: $this->LastTimePoke ";
        $_TxtInformation .= "当前缓存时间: $this->CurrentTimePoke ";
        $_TxtInformation .= "下次缓存时间: $this->NextTimePoke ";

        $_TxtInformation .= "距离下次缓存戳: $this->UnixNowToNext ";    $handl = @fopen($this->CacheConfigFile,"w");
        if($handl)
        {
            @fwrite($handl,$_TxtInformation);
            @fclose($handl);
        }

        if($_IsTimeOut >= time())
        {
            $this->GetCacheData();
        }
    }

    private function ClearCacheFile()
    {
        @unlink($this->CacheFileUrl);
        @unlink($this->CacheConfigFile);
    }

    public function PutCache()
    {
        $this->DataLength = ob_get_length();
        $PutData = ob_get_contents();
        if(!file_exists($this->CacheFileUrl))
        {
            $CreateOK = $this->CreateCache();
            if(!$CreateOK)
            {
                $this->ErrResponse("检查缓存文件时产生错误，缓存文件创建失败");
                return false;
            }
        } else {
            $hanld = @fopen($this->CacheFileUrl,"w");
            if($hanld)
            {       if(@is_writable($this->CacheFileUrl))

				{
                    @flock($hanld, LOCK_EX);
                    $_PutData = @fwrite($hanld,$PutData);
                    @flock($hanld, LOCK_UN);
                    if(!$_PutData)
                    {
                        $this->ErrResponse("无法更改当前缓存文件内容");
                        return false;
                    } else {
                        @fclose($hanld);
                        return true;
                    }
                } else {
                    $this->ErrResponse("缓存文件不可写");
                    return false;
                }
            } else {    $this->ErrResponse("打开缓存文件发生致命错误");
                return false;
            }
        }
    }

    public function GetCacheData()
    {
        $hanld = @fopen($this->CacheFileUrl,"r");
        if($hanld)
        {
            if(@is_readable($this->CacheFileUrl))
            {
                $this->CacheToPage = @file_get_contents($this->CacheFileUrl);
                $IsEmpty = count(file($this->CacheFileUrl));  //判断缓存文件是否为空
                if($IsEmpty > 0)
                {
                    echo $this->CacheToPage;
                    @fclose($hanld);
                      ob_end_flush();
                      exit();
                }
            } else {
                $this->ErrResponse("读取缓存文件内容失败");
                return false;     }

		} else {
            $this->ErrResponse("打开缓存文件失败");
            return false;
        }
    }

    private function ErrResponse($Msg)
    {
        echo $Msg;
    }
}
?>
