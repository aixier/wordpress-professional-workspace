"use client";
import { Button } from "@/components/ui/button";
import { useEffect, useState } from "react";
import toast, { Toaster } from 'react-hot-toast';
import Image from "next/image";

const CTAButton = ({ locale }: { locale: any }) => {
  const [open, setOpen] = useState(false);
  const [isChina, setIsChina] = useState(false);

  const fetchWithTimeout = async (url: string, options = {}, timeout = 5000) => {
    const controller = new AbortController();
    const timeoutId = setTimeout(() => controller.abort(), timeout);

    try {
      const response = await fetch(url, {
        ...options,
        signal: controller.signal,
      });

      if (!response.ok) {
        // throw new Error(`HTTP error! Status: ${response.status}`);
      }
      if (response.status === 0) {
        setIsChina(false) // 设置为非中国用户
      } else {
        setIsChina(true) // 设置为中国用户
      }

    } catch (error: any) {
      // 设置为中国用户
      if (error.name === 'AbortError') {
        setIsChina(true) // 设置为中国用户
        console.log('Request timed out');
      } else {
        console.log(error);
      }
    } finally {
      clearTimeout(timeoutId); // Clean up timeout
    }
  };





  useEffect(() => {
    const getIP = async () => {
      try {
        const response = await fetchWithTimeout('https://www.google.com/generate_204', { mode: 'no-cors' }, 2000);
      } catch (error) {
        console.log(error)
      }
    };
    getIP()
  }, [])


  const checkNetworkEnvironment = async (type: number) => {
    // const mode = localStorage.getItem('wfwefsvisfs432y532q')
    // console.log(mode)

    if (isChina) {
      setOpen(true)
      const url =
        type === 1 ?
          "https://petron01.oss-cn-beijing.aliyuncs.com/download/chrome_extension/TubeScanner%20-%20%E8%B7%A8%E5%A2%83%E7%A4%BE%E5%AA%92%E8%B4%A6%E5%8F%B7%E5%88%86%E6%9E%90%E5%8A%A9%E6%89%8B%E6%8F%92%E4%BB%B6%E5%AE%89%E8%A3%85%E5%8C%85%EF%BC%88%E8%AF%B7%E8%A7%A3%E5%8E%8B%E5%90%8E%E6%8B%96%E8%87%B3%E6%B5%8F%E8%A7%88%E5%99%A8%EF%BC%89.zip" :
          "";
      const response = await fetch(url);
      if (!response.ok) {
        throw new Error(`Network response was not ok: ${response.statusText}`);
      }

      const blob = await response.blob();
      const urlObject = window.URL.createObjectURL(blob);

      const a = document.createElement('a');
      a.style.display = 'none';
      a.href = urlObject;
      a.download = `TubeScanner - 跨境社媒账号分析助手插件安装包（请解压后拖至浏览器）.zip`;

      document.body.appendChild(a);
      a.click();

      window.URL.revokeObjectURL(urlObject);
      document.body.removeChild(a);

    } else {
      window.open(type === 1 ?
        `https://chromewebstore.google.com/detail/${encodeURIComponent('TubeScanner - 跨境社媒账号分析助手')}/hhglbnfglkpfjafjcgjdoalgkpmdjekl` :
        "",
        "_blank" // 打开新标签
      )
    }
  };

  const close = () => {
    setOpen(false)
  }

  const copy = () => {
    const textToCopy = 'chrome://extensions';
    navigator.clipboard.writeText(textToCopy)
      .then(() => {
        console.log('Text copied to clipboard:', textToCopy);
        toast.success('复制成功！');
      })
      .catch(err => {
        console.error('Failed to copy text: ', err);
        toast.success('复制失败');
      });
  }


  return (
    <div className="relative flex items-center justify-center mt-[35px] mb-[35px]">
      <Button
        variant="default"
        className="flex items-center gap-2 bg-[#01304e] hover:bg-[#024975] text-white text-[20px]"
        aria-label="Get Chrome extension"
        onClick={() => checkNetworkEnvironment(1)}
      >
        {locale.title}
      </Button>
      {
        open && <div role="dialog" className=" w-[900px] absolute top-[-480px]  z-[100] bg-gray-100  rounded-2xl shadow-2xl p-[20px]">
          <div className="flex items-center justify-end text-[#000] hover:text-[#fc5c6e]" >
            <div onClick={close}>
              <svg fillRule="evenodd" viewBox="64 64 896 896" focusable="false" data-icon="close" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M799.86 166.31c.02 0 .04.02.08.06l57.69 57.7c.04.03.05.05.06.08a.12.12 0 010 .06c0 .03-.02.05-.06.09L569.93 512l287.7 287.7c.04.04.05.06.06.09a.12.12 0 010 .07c0 .02-.02.04-.06.08l-57.7 57.69c-.03.04-.05.05-.07.06a.12.12 0 01-.07 0c-.03 0-.05-.02-.09-.06L512 569.93l-287.7 287.7c-.04.04-.06.05-.09.06a.12.12 0 01-.07 0c-.02 0-.04-.02-.08-.06l-57.69-57.7c-.04-.03-.05-.05-.06-.07a.12.12 0 010-.07c0-.03.02-.05.06-.09L454.07 512l-287.7-287.7c-.04-.04-.05-.06-.06-.09a.12.12 0 010-.07c0-.02.02-.04.06-.08l57.7-57.69c.03-.04.05-.05.07-.06a.12.12 0 01.07 0c.03 0 .05.02.09.06L512 454.07l287.7-287.7c.04-.04.06-.05.09-.06a.12.12 0 01.07 0z"></path></svg>
            </div>
          </div>

          <div className="m-auto w-[720px] flex flex-col ">
            <div className="p-[10px] w-[370px] bg-[#01304e] text-[#fff] font-bold text-[16px] rounded-2xl">如何安装 TubeScanner - 跨境社媒账号分析助手 Chrome 插件？</div>
            <div className="flex items-center mt-[15px] text-[#000]">
              <span className="text-black font-bold">第一步：</span>
              <span>进入浏览器的扩展程序页面。地址为 </span>
              <span className="text-[#01304e] font-bold">&nbsp;&nbsp;chrome://extensions</span>
              <div className="cursor-pointer ml-[16px] inline-flex" onClick={copy}>
                <Image width={24} height={24} src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjciIGhlaWdodD0iMjciIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHBhdGggZmlsbC1ydWxlPSJldmVub2RkIiBjbGlwLXJ1bGU9ImV2ZW5vZGQiIGQ9Ik05LjQyMSA1LjE0OWMuMzYtLjM2Ljg4Ni0uNjQ5IDEuNDc5LS42NDloNS42NDVjLjIxNyAwIC40MjYuMDg2LjU3OS4yNGwzLjY4MiAzLjY4MWMuMTUzLjE1NC4yNC4zNjIuMjQuNTc5djguMWMwIC41OTMtLjI4OSAxLjExOC0uNjUgMS40NzktLjM2LjM2LS44ODQuNjQ4LTEuNDc4LjY0OEgxMC45Yy0uNTkzIDAtMS4xMTgtLjI4OC0xLjQ3OS0uNjQ4LS4zNi0uMzYtLjY0OC0uODg2LS42NDgtMS40NzlWNi42MjdjMC0uNTkzLjI4OC0xLjExOC42NDgtMS40NzhabTUuODk3Ljk4N0gxMC45Yy0uMDYxIDAtLjE5LjA0LS4zMjIuMTctLjEzLjEzLS4xNjkuMjYtLjE2OS4zMjFWMTcuMWMwIC4wNjEuMDM5LjE5LjE3LjMyMi4xMy4xMy4yNi4xNjkuMzIxLjE2OWg4LjAxOGMuMDYxIDAgLjE5MS0uMDM5LjMyMi0uMTcuMTMtLjEzLjE3LS4yNi4xNy0uMzIxdi02Ljg3M2gtMy4yNzRhLjgxOC44MTggMCAwIDEtLjgxOC0uODE4VjYuMTM2Wm0zLjM0MyAyLjQ1NWgtMS43MDdWNi44ODRsMS43MDcgMS43MDdaIiBmaWxsPSIjMDA3QUZGIi8+PHBhdGggZD0iTTYuMzE4IDkuMDgyYy40NTIgMCAuODE4LjM2Ni44MTguODE4djEwLjQ3M2MwIC4wNjEuMDQuMTkuMTcuMzIxLjEzLjEzLjI2LjE3LjMyMS4xN2g4LjAxOGEuODE4LjgxOCAwIDAgMSAwIDEuNjM2SDcuNjI3Yy0uNTkzIDAtMS4xMTgtLjI4OC0xLjQ3OC0uNjQ5LS4zNi0uMzYtLjY0OS0uODg1LS42NDktMS40NzhWOS45YzAtLjQ1Mi4zNjYtLjgxOC44MTgtLjgxOFoiIGZpbGw9IiMwMDdBRkYiLz48L3N2Zz4=" alt="copy" />
                <span className="text-[#007aff] font-bold  letter-spacing-[.25px]">复制</span>
              </div>
            </div>
            <div className="mt-[15px] text-[#000]">
              <span className="text-black font-bold">第二步：</span>
              <span>开启扩展程序页面右上角的『开发者模式』按钮。</span>
              <div className="mt-[12px]">
                <div className="w-[720px] h-[130px]">
                  <Image src="/images/20241112-112205.jpg" alt="lo" width={720} height={130} style={{ objectFit: 'cover' }} />
                </div>
              </div>
            </div>
            <div className="mt-[15px] mb-[15px] text-[#000]">
              <span className="text-black font-bold">第三步：</span>
              <span>解压下载好的 TubeScanner 插件安装包.zip 文件，</span>
              {/* <span className="text-[#01304e] font-bold"> TubeScanner.crx </span> */}
              <span>将其拖动到扩展程序页面以完成安装。</span>
              <div className="mt-[12px] w-[720px] h-[200px]">
                <Image src="/images/20241112-112224.jpg" alt="lo" width={720} height={200} style={{ objectFit: 'cover' }} />
              </div>
            </div>
          </div>
        </div>
      }

      <Toaster />
    </div>

  );
};

export default CTAButton;
