-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 25, 2025 at 01:20 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sunnnytech`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `shipping_name` varchar(255) DEFAULT NULL,
  `shipping_address` text DEFAULT NULL,
  `shipping_phone` varchar(20) DEFAULT NULL,
  `shipping_city` varchar(255) DEFAULT NULL,
  `shipping_zip` varchar(20) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_amount`, `order_date`, `shipping_name`, `shipping_address`, `shipping_phone`, `shipping_city`, `shipping_zip`, `status`) VALUES
(24, 1, 2972.99, '2025-07-24 00:43:26', 'amine bigfaine', 'rue 629 agadir ', '0686455434', 'agadir', '80000', 'delivered'),
(25, 1, 189.00, '2025-07-24 00:44:14', 'amine bigfaine', 'rue 629 agadir ', '0686455434', 'agadir', '80000', 'cancelled'),
(26, 1, 1399.99, '2025-07-24 00:50:43', 'amine bigfaine', 'rue 629 agadir ', '0686455434', 'agadir', '80000', 'delivered'),
(27, 1, 1499.99, '2025-07-24 00:53:30', 'amine bigfaine', 'rue 629 agadir ', '0686455434', 'agadir', '80000', 'delivered'),
(28, 1, 1499.99, '2025-07-24 01:00:27', 'amine bigfaine', 'rue 629 agadir ', '0686455434', 'agadir', '80000', 'cancelled'),
(29, 1, 1499.99, '2025-07-24 02:05:15', 'amine bigfaine ', 'rue 629 agadir ', '0686455434', 'agadir', '80000', 'delivered'),
(30, 1, 2972.99, '2025-07-24 02:09:16', 'amine bigfaine ', 'rue 629 agadir ', '0686455434', 'agadir', '80000', 'pending'),
(31, 1, 2972.99, '2025-07-25 02:16:15', 'amine bigfaine ', 'rue 629 agadir ', '0686455434', 'agadir', '80000', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(19, 24, 14, 1, 2972.99),
(20, 25, 19, 1, 189.00),
(21, 26, 10, 1, 1399.99),
(22, 27, 1, 1, 1499.99),
(23, 28, 1, 1, 1499.99),
(24, 29, 1, 1, 1499.99),
(25, 30, 14, 1, 2972.99),
(26, 31, 14, 1, 2972.99);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `rating` decimal(2,1) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image_url1` varchar(255) DEFAULT NULL,
  `image_url2` varchar(255) DEFAULT NULL,
  `image_url3` varchar(255) DEFAULT NULL,
  `is_hot_release` tinyint(1) DEFAULT 0,
  `is_latest_release` tinyint(1) DEFAULT 0,
  `details` text DEFAULT NULL,
  `specs_cpu` varchar(255) DEFAULT NULL,
  `specs_gpu` varchar(255) DEFAULT NULL,
  `specs_ram` varchar(255) DEFAULT NULL,
  `specs_storage` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `image_url`, `price`, `rating`, `description`, `image_url1`, `image_url2`, `image_url3`, `is_hot_release`, `is_latest_release`, `details`, `specs_cpu`, `specs_gpu`, `specs_ram`, `specs_storage`) VALUES
(1, 'ApexTech Phantom Gaming PC', 'Desktops', '/SuNNNyTech/images/products/product-1.webp', 1499.99, 3.0, 'Power through any challenge with the ApexTech Phantom Gaming PC — featuring ultra-fast processors, RTX graphics, and sleek RGB design. Built for gamers who demand the best.', '/SuNNNyTech/images/details/1/product-1-1.webp', '/SuNNNyTech/images/details/1/product-1-2.webp', '/SuNNNyTech/images/details/1/product-1-3.webp', 1, 0, '• Powered by the latest Intel Core i9 or AMD Ryzen 9 processor for top-tier performance  \n• NVIDIA GeForce RTX 4090 or AMD Radeon RX 7900 XTX graphics card for ultra-realistic graphics and smooth 4K gameplay  \n• 64GB DDR5 RAM for seamless multitasking and optimal gaming performance  \n• 1TB NVMe SSD for rapid load times, fast boot-ups, and ample storage  \n• 2TB HDD for additional storage capacity for all your games, media, and files  \n• Advanced liquid cooling system to keep your system cool during long gaming sessions  \n• 1000W 80+ Gold certified power supply for reliable and efficient performance  \n• High-quality, noise-dampening chassis for a quiet yet powerful setup  \n• Customizable RGB lighting to match your gaming rig aesthetic  \n• Windows 11 Pro pre-installed for the latest software enhancements and security features  \n• Multiple USB 3.2, USB-C, HDMI 2.1, and DisplayPort connections for versatile connectivity  \n• Support for VR and high-refresh-rate displays for the most immersive gaming experience  \n• Tool-free access for easy upgrades and future-proofing  \n• Built-in Wi-Fi 6 and Bluetooth 5.2 for fast and reliable wireless connectivity  \n', 'AMD Ryzen 9 processor for top-tier performance', 'AMD Radeon RX 7900 XTX ', '64GB DDR5 ', '1TB NVMe SSD and 2TB HDD'),
(2, 'UltraSync 27\" 1440p Gaming Monitor', 'Accessoires', '/SuNNNyTech/images/products/product-2.webp', 399.99, 4.5, 'Immerse yourself in stunning clarity with the UltraSync 27\" 1440p Gaming Monitor. Designed for competitive and casual gamers alike, it delivers ultra-smooth gameplay, vibrant colors, and razor-sharp details. Perfect for next-gen gaming and professional setups.', '/SuNNNyTech/images/details/2/1.jpg', '/SuNNNyTech/images/details/2/2.jpg', '/SuNNNyTech/images/details/2/3.jpg', 1, 0, '• 27-inch QHD (2560x1440) IPS Display  \n• 165Hz Refresh Rate for ultra-smooth gameplay  \n• 1ms Response Time for lightning-fast reactions  \n• NVIDIA G-SYNC & AMD FreeSync Compatible  \n• Wide 99% sRGB Color Gamut for vivid accuracy  \n• HDR10 Support for enhanced contrast and realism  \n• Ultra-thin bezels and sleek frameless design  \n• Adjustable stand: Tilt, Swivel, Height, Pivot  \n• Multiple ports: 2x HDMI 2.0, 1x DisplayPort 1.4, USB Hub  \n• Eye Care Technology: Flicker-Free + Low Blue Light\n', NULL, NULL, NULL, NULL),
(3, 'ForgeFlex Creator Laptop', 'Laptops', '/SuNNNyTech/images/products/product-3.webp', 2199.00, 5.0, 'Unlock your creative potential with the ForgeFlex Creator Laptop. Engineered for content creators, designers, and professionals, this powerhouse features cutting-edge performance, stunning visuals, and a sleek design to handle demanding workloads with ease. Perfect for 3D modeling, video editing, and intense multitasking.', '/SuNNNyTech/images/details/3/1.webp', '/SuNNNyTech/images/details/3/2.webp', '/SuNNNyTech/images/details/3/3.webp', 1, 0, '• 15.6-inch 4K OLED Touchscreen Display  \n• Intel Core i9 14th Gen Processor for unmatched performance  \n• NVIDIA RTX 4070 8GB for professional-grade graphics  \n• 32GB DDR5 RAM for smooth multitasking  \n• 1TB PCIe NVMe SSD for lightning-fast storage  \n• 100% Adobe RGB for true-to-life color accuracy  \n• Supports up to 3 external monitors for multi-display setups  \n• 100W USB-C charging for ultra-fast power delivery  \n• 1080p webcam with AI noise cancellation  \n• Advanced thermal design with liquid cooling system  \n• High-end aluminum chassis with a thin and light profile  \n• Ultra-long battery life (up to 12 hours on a single charge)  \n• Full set of ports: 2x USB-C, 2x USB-A, HDMI 2.1, SD Card Reader  \n', 'Intel Core i9 14th Gen Processor', 'NVIDIA RTX 4070 8GB', '32GB DDR5 RAM', '1TB PCIe NVMe SSD '),
(4, 'Nova keyboard ', 'Accessoires', '/SuNNNyTech/images/products/product-4.webp', 70.00, 4.0, 'Elevate your typing experience with the Nova Keyboard. Designed for gamers and professionals alike, this sleek mechanical keyboard offers responsive keys, customizable RGB lighting, and a durable build to withstand even the most intense typing sessions. Perfect for work, play, and everything in between.', '/SuNNNyTech/images/details/4/1.jpg', '/SuNNNyTech/images/details/4/2.jpg', '/SuNNNyTech/images/details/4/3.jpg', 0, 0, '• High-performance mechanical switches for tactile feedback  \n• RGB backlighting with customizable effects and millions of colors  \n• 100% anti-ghosting with N-Key rollover for precision  \n• Aluminum frame for a durable, premium feel  \n• Adjustable height with two-step feet for ergonomic comfort  \n• Full-size layout with dedicated media controls  \n• Compatible with Windows, macOS, and Linux  \n• Braided cable for improved durability  \n• Detachable cable for easy transport  \n• 50 million keystroke lifespan per switch for long-lasting durability  \n• Software support for macros and key remapping  \n', NULL, NULL, NULL, NULL),
(5, 'NovaTech PC Gaming', 'Desktops', '/SuNNNyTech/images/products/product-5.webp', 1099.99, 5.0, 'Take your gaming to the next level with the NovaTech PC Gaming system. Equipped with the latest hardware, including a powerful CPU, high-end GPU, and fast SSD storage, this gaming powerhouse ensures ultra-smooth performance, crisp graphics, and fast load times. Perfect for both casual gamers and esports enthusiasts.', '/SuNNNyTech/images/details/5/1.jpg', '/SuNNNyTech/images/details/5/2.jpg', '/SuNNNyTech/images/details/5/3.jpg', 0, 1, '• Intel Core i7 13th Gen Processor for high-speed performance  \n• NVIDIA GeForce RTX 4080 16GB for stunning graphics and performance  \n• 32GB DDR5 RAM for seamless multitasking  \n• 1TB NVMe SSD for rapid load times and smooth gameplay  \n• 850W Fully Modular PSU for stable power delivery  \n• Custom RGB lighting for a personalized gaming setup  \n• Advanced cooling system with multiple fans and liquid cooling  \n• Motherboard with Wi-Fi 6 and Bluetooth 5.0 support  \n• USB 3.2 Gen 2 ports for fast data transfer  \n• Windows 11 Pro pre-installed for the latest features  \n• Compact, sleek case design with optimal airflow  \n• Supports VR and 4K gaming for an immersive experience  \n', 'Intel Core i7 13th Gen Processor', 'NVIDIA GeForce RTX 4080 16GB', '32GB DDR5 RAM', '1TB NVMe SSD'),
(6, 'ShadowForce X', 'Desktops', '/SuNNNyTech/images/products/product-6.webp', 1900.00, 4.0, 'Unleash unparalleled power with the ShadowForce X, a cutting-edge gaming PC designed for extreme performance. Featuring top-of-the-line hardware and a futuristic design, this machine ensures ultra-smooth gameplay, high FPS, and incredible graphics for the ultimate gaming experience.', '/SuNNNyTech/images/details/6/1.jpg', '/SuNNNyTech/images/details/6/2.jpg', '/SuNNNyTech/images/details/6/3.jpg', 0, 0, '• Intel Core i9 14th Gen Processor for unstoppable speed  \n• NVIDIA GeForce RTX 4090 24GB for ultra-realistic graphics and performance  \n• 64GB DDR5 RAM for flawless multitasking and gaming  \n• 2TB PCIe NVMe SSD for lightning-fast boot and load times  \n• 1200W Fully Modular PSU to support peak performance  \n• Customizable RGB lighting for a personalized look  \n• Premium water-cooling system for optimal thermal management  \n• Motherboard with support for PCIe 5.0 and DDR5 RAM  \n• 3x 4K displays and VR-ready for immersive gaming experiences  \n• Wi-Fi 6E and Bluetooth 5.2 for ultra-fast connectivity  \n• Sleek, compact case with premium tempered glass panels and RGB accents  \n• Noise-canceling design for a quieter gaming experience  \n• Windows 11 Pro for gaming-optimized features  \n', 'Intel Core i9 14th Gen Processor', 'NVIDIA GeForce RTX 4090 24GB ', '64GB DDR5 RAM', '2TB PCIe NVMe SSD'),
(7, 'NovaEdge 32Q', 'Accessoires', '/SuNNNyTech/images/products/product-7.webp', 429.00, 4.2, 'Experience cinematic clarity with the NovaEdge 32\" Q monitor. Featuring a stunning 4K resolution, ultra-fast refresh rate, and a wide color gamut, this monitor is designed for gamers, creators, and professionals who demand nothing but the best for their viewing experience.', '/SuNNNyTech/images/details/7/1.webp', '/SuNNNyTech/images/details/7/2.webp', '/SuNNNyTech/images/details/7/3.webp', 0, 0, '• 32-inch 4K UHD (3840x2160) IPS display for crystal-clear resolution  \n• 165Hz refresh rate for ultra-smooth gaming and video playback  \n• 1ms response time for lag-free gaming and sharp visuals  \n• 98% DCI-P3 color gamut for exceptional color accuracy  \n• HDR400 support for enhanced contrast and vivid details  \n• NVIDIA G-SYNC and AMD FreeSync compatibility for tear-free gaming  \n• Slim bezels for a sleek, immersive viewing experience  \n• Ergonomic stand with tilt, swivel, height adjustability, and pivot  \n• USB-C, HDMI 2.1, DisplayPort 1.4 for versatile connectivity  \n• VESA mount compatibility for easy wall mounting or multi-monitor setups  \n• Built-in speakers with rich sound for added convenience  \n• Blue light reduction and flicker-free technology for eye comfort  \n', NULL, NULL, NULL, NULL),
(8, 'ForgeFlex UltraBook (Snapdragon X Edition)', 'Laptops', '/SuNNNyTech/images/products/product-8.webp', 999.99, 4.0, 'The ForgeFlex UltraBook (Snapdragon X Edition) is a powerhouse of performance and portability. Powered by the cutting-edge Snapdragon X processor, this ultra-thin laptop delivers blazing-fast speeds, exceptional battery life, and a sleek design, making it perfect for both work and play on the go.', '/SuNNNyTech/images/details/8/1.jpg', '/SuNNNyTech/images/details/8/2.jpg', '/SuNNNyTech/images/details/8/3.jpg', 0, 1, '• Qualcomm Snapdragon X Gen 3 processor for lightning-fast performance  \n• 16GB LPDDR5 RAM for seamless multitasking and smooth operation  \n• 512GB NVMe SSD for ultra-fast data transfer and storage  \n• 13.3-inch 2K AMOLED display with ultra-thin bezels for crisp, vibrant visuals  \n• Up to 12 hours of battery life with fast charging capabilities  \n• Lightweight design (weighs just 1.2 kg) for easy portability  \n• Windows 11 Pro with built-in Snapdragon support for productivity and gaming  \n• 5G connectivity for ultra-fast internet on the go  \n• Dual front-facing speakers for immersive sound experience  \n• Full-size backlit keyboard for comfortable typing  \n• USB-C, USB-A, HDMI, and Thunderbolt 4 ports for versatile connectivity  \n• Wi-Fi 6 and Bluetooth 5.1 for optimal connectivity  \n• Premium aluminum alloy body for durability and style  \n', 'intel Core i7 14Gen processor', 'AMD RX6600XT', '16GB DDR4', '512GB NVMe SSD'),
(9, 'x570 pro ssd gen 5', 'Harddisks', '/SuNNNyTech/images/products/product-9.webp', 120.00, 4.0, 'Speed up your system like never before with the X570 Pro SSD Gen 5. Built with next-gen PCIe Gen 5.0 technology, this solid-state drive delivers lightning-fast read and write speeds for the ultimate performance boost. Ideal for gamers, creators, and professionals seeking unmatched storage efficiency and reliability.', '/SuNNNyTech/images/details/9/1.webp', '/SuNNNyTech/images/details/9/2.webp', '/SuNNNyTech/images/details/9/3.webp', 0, 0, '• PCIe Gen 5.0 interface for ultra-fast read/write speeds (up to 12,000 MB/s read, 10,000 MB/s write)  \n• 1TB or 2TB capacity options for all your storage needs  \n• Advanced NAND flash technology for exceptional durability and reliability  \n• DRAM cache for improved performance and faster load times  \n• Heat management with built-in heatsink for consistent performance during heavy tasks  \n• Compatible with the latest motherboards supporting PCIe Gen 5.0  \n• Built-in error-correcting code (ECC) for data integrity  \n• Low power consumption for energy efficiency  \n• Secure encryption support for protecting your data  \n• Works seamlessly with Windows 10/11 and other major operating systems  \n• Compact M.2 2280 form factor for easy installation in compatible devices  \n', NULL, NULL, NULL, NULL),
(10, 'Thunder Gaming Laptop', 'Laptops', '/SuNNNyTech/images/products/product-10.webp', 1399.99, 3.5, 'Dominate the battlefield with the Thunder Gaming Laptop. Equipped with powerful hardware and cutting-edge cooling technology, this laptop delivers exceptional performance and smooth gameplay, ensuring you\'re always ahead of the competition.', '/SuNNNyTech/images/details/10/1.jpg', '/SuNNNyTech/images/details/10/2.jpg', '/SuNNNyTech/images/details/10/3.jpg', 0, 1, '• Intel Core i7 13th Gen processor for high-performance gaming  \n• NVIDIA GeForce RTX 4080 16GB for real-time ray tracing and ultra-realistic graphics  \n• 16GB DDR5 RAM for seamless multitasking and smooth gameplay  \n• 1TB NVMe SSD for lightning-fast storage and quick load times  \n• 15.6-inch Full HD (1920x1080) display with 144Hz refresh rate for ultra-smooth visuals  \n• Advanced cooling system with dual fans and copper heat pipes for optimal thermal performance  \n• RGB backlit keyboard for a customizable gaming experience  \n• 720p HD webcam for clear video calls and streams  \n• Wi-Fi 6 and Bluetooth 5.2 for fast connectivity  \n• USB-C, USB 3.2, HDMI, and Thunderbolt 4 ports for versatile connectivity  \n• 99Wh battery for up to 8 hours of gaming or productivity on the go  \n• Windows 11 Pro optimized for gaming and productivity  \n', 'Intel Core i7 13th Gen processor ', 'NVIDIA GeForce RTX 4080 16GB', '16GB DDR5 RAM', '1TB NVMe SSD'),
(11, 'VenomStrike', 'Desktops', '/SuNNNyTech/images/products/product-11.webp', 1599.00, 4.3, 'Unleash lethal power with the VenomStrike gaming laptop. Featuring top-tier components, a sleek design, and cutting-edge cooling, it’s built to handle the most demanding games with ease, delivering unmatched performance in every battle.', '/SuNNNyTech/images/details/11/1.webp', '/SuNNNyTech/images/details/9/2.jpg', '/SuNNNyTech/images/details/9/3.webp', 0, 0, '• Intel Core i9 13th Gen processor for lightning-fast performance and multitasking  \n• NVIDIA GeForce RTX 4090 16GB graphics card for ultra-realistic graphics and smooth gameplay  \n• 32GB DDR5 RAM for seamless multitasking and high-performance gaming  \n• 2TB NVMe SSD for ample storage and rapid load times  \n• 17.3-inch 4K UHD (3840x2160) display with 240Hz refresh rate for ultra-crisp and smooth visuals  \n• Advanced vapor chamber cooling system for superior heat dissipation during intense gaming sessions  \n• RGB mechanical keyboard with customizable lighting for a personalized gaming setup  \n• 1080p HD webcam for crystal-clear streaming and video conferencing  \n• Wi-Fi 6E and Bluetooth 5.2 for ultra-fast connectivity  \n• Multiple USB 3.2, Thunderbolt 4, HDMI 2.1, and Ethernet ports for versatile connectivity options  \n• 99Wh battery for up to 6 hours of gaming or heavy-duty work on the go  \n• Windows 11 Pro pre-installed for a smooth and optimized experience  \n', 'Intel Core i9 13th Gen processor', 'NVIDIA GeForce RTX 4090 16GB', '32GB DDR5 RAM', ' 2TB NVMe SSD'),
(12, 'TitanStorm', 'Laptops', '/SuNNNyTech/images/products/product-12.webp', 1799.00, 4.0, 'Unleash the storm of power and precision with the TitanStorm gaming laptop. Featuring advanced cooling, an ultra-fast display, and powerhouse internals, it\'s engineered to deliver smooth, lag-free gaming and exceptional performance in the most demanding environments.', '/SuNNNyTech/images/details/12/1.jpg', '/SuNNNyTech/images/details/12/2.jpg', '/SuNNNyTech/images/details/12/3.jpg', 0, 0, '• Intel Core i7 13th Gen processor for outstanding performance and multitasking  \n• NVIDIA GeForce RTX 4080 16GB for exceptional graphics and smooth gaming  \n• 32GB DDR5 RAM for seamless multitasking and peak performance  \n• 1TB NVMe SSD for fast boot times, quick load speeds, and ample storage  \n• 15.6-inch Full HD (1920x1080) display with 165Hz refresh rate for ultra-smooth visuals  \n• Advanced cooling system with dual fans and heat pipes for maximum heat dissipation  \n• RGB backlit mechanical keyboard for responsive gameplay and a customizable look  \n• 720p HD webcam for clear video calls and streaming  \n• Wi-Fi 6E and Bluetooth 5.2 for the fastest connectivity and performance  \n• Multiple USB 3.2, HDMI, Thunderbolt 4, and Ethernet ports for versatile connectivity  \n• 80Wh battery for up to 7 hours of gaming or work on the go  \n• Windows 11 Pro for a smooth and responsive user experience  \n', 'Intel Core i9 14th Gen Processor ', 'NVIDIA RTX 4070 8GB', ' 32GB DDR5 RAM', '1TB PCIe NVMe SSD'),
(13, 'PhantomScreen Z34', 'Accessoires', '/SuNNNyTech/images/products/product-13.webp', 549.00, 4.3, 'Immerse yourself in the future of gaming and entertainment with the PhantomScreen Z34. This ultra-wide 34-inch curved monitor delivers stunning visuals with 144Hz refresh rate and 1ms response time, designed for gamers and professionals who demand the best.', '/SuNNNyTech/images/details/13/1.jpg', '/SuNNNyTech/images/details/13/2.jpg', '/SuNNNyTech/images/details/13/3.jpg', 0, 0, '• 34-inch Ultra-Wide QHD (3440x1440) curved display for immersive viewing  \n• 144Hz refresh rate for ultra-smooth gaming and responsive performance  \n• 1ms response time for minimal motion blur and crisp visuals during fast action  \n• Curved 1800R design for a more natural and comfortable viewing experience  \n• HDR10 support for vibrant colors and exceptional contrast  \n• NVIDIA G-SYNC and AMD FreeSync Premium for tear-free, smooth gameplay  \n• 98% sRGB color coverage for precise and accurate color reproduction  \n• Multiple display modes for gaming, movies, and productivity  \n• Adjustable stand with tilt, height, and swivel options for ergonomic comfort  \n• Connectivity options include HDMI 2.0, DisplayPort 1.4, and USB 3.0 hub  \n• Built-in speakers for convenience or option to connect external audio devices  \n• VESA mount compatibility for flexible mounting options  \n• Blue light reduction and flicker-free technology for reduced eye strain  \n', NULL, NULL, NULL, NULL),
(14, 'ForgeFlex Pro Desktop (Ryzen 9 9950X3D)', 'Desktops', '/SuNNNyTech/images/products/product-14.webp', 2972.99, 4.5, 'Step into a new era of computing with the ForgeFlex Pro Desktop (Ryzen 9 9950X3D). Powered by the latest AMD Ryzen 9 9950X3D processor, this powerhouse delivers unparalleled performance, speed, and efficiency, making it perfect for professionals, content creators, and gamers alike.', '/SuNNNyTech/images/details/14/1.webp', '/SuNNNyTech/images/details/14/2.webp', '/SuNNNyTech/images/details/14/3.webp', 0, 1, '• AMD Ryzen 9 9950X3D processor with 16 cores and 32 threads for extreme performance  \n• NVIDIA GeForce RTX 4090 24GB graphics card for stunning visuals and smooth 4K gaming  \n• 64GB DDR5 RAM for seamless multitasking and handling demanding workloads  \n• 2TB NVMe SSD for ultra-fast boot times, quick load speeds, and ample storage  \n• 12TB HDD storage for massive data capacity and backup  \n• Liquid cooling system for optimal thermal management during extended high-performance use  \n• 1000W 80+ Platinum power supply for efficient energy usage and reliable performance  \n• Windows 11 Pro pre-installed for enhanced productivity and security features  \n• USB 3.2, Thunderbolt 4, and HDMI 2.1 ports for flexible connectivity options  \n• Customizable RGB lighting for a personalized aesthetic  \n• Multiple expansion slots for future upgrades and enhancements  \n• High-quality, noise-reducing chassis for a quiet and efficient working environment  \n', 'AMD Ryzen 9 9950X3D processor ', 'NVIDIA GeForce RTX 4090 24GB', '64GB DDR5 RAM', '2TB NVMe SSD and 12TB HDD'),
(15, 'Wireless Gaming Mouse', 'Accessoires', '/SuNNNyTech/images/products/product-15.webp', 79.99, 4.5, 'Take your gaming to the next level with the Wireless Gaming Mouse. Designed for precision and comfort, this mouse offers ultra-low latency, customizable DPI settings, and long-lasting battery life, ensuring you stay in control during every gaming session.', '/SuNNNyTech/images/details/15/1.jpg', '/SuNNNyTech/images/details/15/2.jpg', '/SuNNNyTech/images/details/15/3.jpg', 0, 0, '• Ultra-low latency wireless connection with 2.4GHz technology for lag-free gaming  \r\n• High-precision optical sensor with adjustable DPI settings (up to 16,000 DPI) for precise tracking  \r\n• Ergonomic design with textured grips for comfort during long gaming sessions  \r\n• 6 programmable buttons for customizable commands and shortcuts  \r\n• RGB lighting with customizable color profiles for a personalized look  \r\n• Rechargeable battery with up to 60 hours of gaming on a single charge  \r\n• Lightweight design (approx. 100g) for fast and responsive movements  \r\n• Compatible with both Windows and macOS systems  \r\n• Durable switches rated for up to 50 million clicks for long-lasting performance  \r\n• On-the-fly DPI adjustment button for quick sensitivity changes during gameplay  \r\n• Anti-slip feet for smooth, consistent gliding across various surfaces  \r\n', NULL, NULL, NULL, NULL),
(16, 'Powered Webcam (4K with Auto-Framing)', 'Accessoires', '/SuNNNyTech/images/products/product-16.webp', 99.99, 3.0, 'Experience crystal-clear video calls and streaming with the Powered Webcam (4K with Auto-Framing). Featuring 4K resolution and automatic subject tracking, this webcam ensures you always look your best, whether for meetings, content creation, or video chats.', '/SuNNNyTech/images/details/16/1.webp', '/SuNNNyTech/images/details/16/2.webp', '/SuNNNyTech/images/details/16/3.webp', 0, 0, '• 4K Ultra HD resolution for incredibly clear and detailed video  \r\n• Auto-framing technology that automatically adjusts the camera angle to keep you in focus  \r\n• 90-degree wide field of view for optimal framing and multi-person calls  \r\n• Built-in microphone with noise-cancelling technology for clear audio  \r\n• Plug-and-play USB connection for easy setup with no additional drivers required  \r\n• Adjustable mounting clip for flexible positioning on desktops, laptops, or monitors  \r\n• Compatible with most video conferencing platforms, including Zoom, Skype, and Teams  \r\n• Automatic light correction for optimal video quality in various lighting conditions  \r\n• Low-light enhancement to ensure clear images even in dim environments  \r\n• Privacy shutter for added security when not in use  \r\n• High-quality glass lens for sharp image clarity and color accuracy  \r\n', NULL, NULL, NULL, NULL),
(17, 'Intel Core i9-14900K TRAY | 24 Cores | 32 Threads | Up to 6.0GHz', 'CPUs', '/SuNNNyTech/images/products/product-17.png', 599.00, 4.0, 'Extreme Power for Elite Users\r\nThe Intel Core i9-14900K is built for gamers, creators, and professionals who need cutting-edge performance with AI-ready capabilities.', '/SuNNNyTech/images/products/product-17.png', '/SuNNNyTech/images/details/17/1.png', '/SuNNNyTech/images/details/17/2.jpg', 0, 0, 'Processor 24 Cores / 32 Threads\r\n8 Performance-Cores (3.2 GHz – 5.8 GHz) + 16 Efficient-Cores (up to 4.4 GHz)\r\n36 MB L3 cache + 32 MB L2 cache\r\nUnlocked (multiplier coefficient unlocked for overclocking)\r\nIGP: Intel UHD Graphics 770\r\nMemory controller: DDR4 / DDR5\r\nPCI-E 5.0 compatible\r\nTDP: 125W\r\nMax. TDP (Turbo Power): 253W', NULL, NULL, NULL, NULL),
(18, 'Intel Core i7-14700KF | 20 Cores | 28 Threads | Up to 5.6GHz ', 'CPUs', '/SuNNNyTech/images/products/product-18.png', 479.00, 4.0, 'The i7-14700KF brings a powerful blend of speed and multitasking, with AI acceleration and overclocking support for top-tier performance.', '/SuNNNyTech/images/products/product-18.png', '/SuNNNyTech/images/details/17/1.png', '/SuNNNyTech/images/details/17/2.jpg\r\n', 0, 0, 'Processor 20 Cores / 28 Threads\r\n8 Performance-Cores (3.4 GHz – 5.6 GHz) + 12 Efficient-Cores (up to 4.3 GHz)\r\nL3 Cache 33 MB + L2 Cache 28 MB\r\nUnlocked (multiplication coefficient unlocked for overclocking)\r\nIGP: None\r\nMemory controller: DDR4 / DDR5\r\nPCI-E 5.0 compatible\r\nTDP: 125W\r\nMax. TDP (Turbo Power): 253W', NULL, NULL, NULL, NULL),
(19, 'Intel Core i5-13400F (2.5 GHz / 4.6 GHz)', 'CPUs', '/SuNNNyTech/images/products/product-19.png', 189.00, 4.0, 'Processeur 10 Cores / 16 Threads\r\n6 Performance-Cores (2.5 GHz – 4.6 GHz) + 4 Efficient-Cores (1.8 GHz – 3.3 GHz)\r\nCache L3 20 Mo + Cache L2 9.5 Mo\r\nIGP : Aucun\r\nContrôleur mémoire : DDR4 / DDR5\r\nCompatible PCI-E 5.0\r\nTDP : 65W\r\nTDP max. (Turbo Power) : 148W\r\nVentilateur Intel Laminar RM1 inclus', '/SuNNNyTech/images/products/product-19.png', '/SuNNNyTech/images/details/17/1.png', '/SuNNNyTech/images/details/17/2.jpg', 0, 0, 'INTEL CORE I5-13400F 10-CORE (6P+4E)\r\nProcesseur 10 Cores / 16 Threads\r\n6 Performance-Cores (2.5 GHz – 4.6 GHz) + 4 Efficient-Cores (1.8 GHz – 3.3 GHz)\r\nCache L3 20 Mo + Cache L2 9.5 Mo\r\nIGP : Aucun\r\nContrôleur mémoire : DDR4 / DDR5\r\nCompatible PCI-E 5.0\r\nTDP : 65W\r\nTDP max. (Turbo Power) : 148W\r\nVentilateur Intel Laminar RM1 inclus', NULL, NULL, NULL, NULL),
(20, 'AMD Ryzen 9 9900X ( 4.4 GHz | 5.6 GHz )', 'CPUs', '/SuNNNyTech/images/products/product-20.png', 639.00, 4.0, 'Put the AMD Ryzen 9 9900X processor at the heart of your configuration and enjoy spectacular performance that lasts. You’ll be able to play, create and work with remarkable fluidity and formidable efficiency in all areas.', '/SuNNNyTech/images/products/product-20.png', '/SuNNNyTech/images/details/20/1.webp', '/SuNNNyTech/images/details/20/2.webp\r\n', 0, 0, 'Product Type: CPU / Processor\r\nModel: AMD Ryzen 9 9900X (Zen 5 Architecture)\r\nCores/Threads: 12 Cores / 24 Threads\r\nBase Clock: 4.4 GHz\r\nBoost Clock: Up to 5.6 GHz\r\nSocket: AM5\r\nCache: 76MB Total (64MB L3 + 12MB L2)\r\nTDP: 120W', NULL, NULL, NULL, NULL),
(21, 'AMD Ryzen 7 9800X3D (4.7 GHz / 5.2 GHz)', 'CPUs', '/SuNNNyTech/images/products/product-21.webp', 699.00, 4.0, 'Processeur 8-Core 16-Threads socket AM5 AMD 3D V-Cache 104 Mo 4 nm TDP 120W . Le processeur AMD Ryzen 7 9800X3D basé sur l’architecture Zen 5 et doté de la technologie AMD 3D V-Cache vous permet d’atteindre de nouveaux sommets. Avec des fréquences d’images plus fluides et des performances spectaculaires, ce processeur garantit d’enchainer les parties sans efforts.', '/SuNNNyTech/images/products/product-21.webp', '/SuNNNyTech/images/details/20/1.webp', '/SuNNNyTech/images/details/20/2.webp\r\n', 0, 0, 'Processeur 8-Core 16-Threads socket AM5 AMD 3D V-Cache 104 Mo 4 nm TDP 120W . Le processeur AMD Ryzen 7 9800X3D basé sur l’architecture Zen 5 et doté de la technologie AMD 3D V-Cache vous permet d’atteindre de nouveaux sommets. Avec des fréquences d’images plus fluides et des performances spectaculaires, ce processeur garantit d’enchainer les parties sans efforts.', NULL, NULL, NULL, NULL),
(22, 'AMD Ryzen 5 7600 Wraith Stealth (3.8 GHz / 5.1 GHz)', 'CPUs', '/SuNNNyTech/images/products/product-22.png', 200.00, 4.0, 'Le processeur pour PC de bureau AMD Ryzen 5 7600 propose 6 cœurs natifs et 12 cœurs logiques pour un traitement multitâche agréablement fluide. Grâce à sa fréquence native élevée et à son mode Turbo Core ajustant la puissance en fonction des besoins, ce CPU AMD Ryzen de nouvelle génération délivre des performances exceptionnelles dans tous les domaines : Jeux vidéo, multitâche intensif, édition vidéo, modélisation 3D et bien plus encore. Le cache L3 de 32 Mo permet en outre le traitement ultrarapide d’un grand nombre d’instructions grâce à des latences réduites.', '/SuNNNyTech/images/products/product-22.png', '/SuNNNyTech/images/details/17/1.png', '/SuNNNyTech/images/details/20/2.webp\r\n', 0, 0, 'Le processeur pour PC de bureau AMD Ryzen 5 7600 propose 6 cœurs natifs et 12 cœurs logiques pour un traitement multitâche agréablement fluide. Grâce à sa fréquence native élevée et à son mode Turbo Core ajustant la puissance en fonction des besoins, ce CPU AMD Ryzen de nouvelle génération délivre des performances exceptionnelles dans tous les domaines : Jeux vidéo, multitâche intensif, édition vidéo, modélisation 3D et bien plus encore. Le cache L3 de 32 Mo permet en outre le traitement ultrarapide d’un grand nombre d’instructions grâce à des latences réduites.', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `rating` int(1) NOT NULL,
  `review_text` text NOT NULL,
  `review_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `customer_name`, `rating`, `review_text`, `review_date`) VALUES
(1, 1, 'SuNNNy_r', 5, 'nice product', '2025-05-11 17:22:31');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `rating` decimal(2,1) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `comment`, `rating`, `image_url`) VALUES
(1, 'Jemma Stone', 'Absolutely loved the fine hoodies I brought from this place. 11/10 would buy from here again.', 5.0, './images/testimonials/jemma.jpg'),
(2, 'Rachel Myers', 'who put up this ugly website. Recommend firing that guy. Jk good site pls no remove comment.', 4.0, './images/testimonials/rachel.jpg'),
(3, 'Anne Jordan', 'No wonder this site is so popular! It has the best prices in the city and really like the styles.', 4.5, './images/testimonials/anne.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('admin','support','user') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `address`, `phone`, `role`) VALUES
(1, 'SuNNNy_r admin', 'sunnny_r@dev.pl', '$2y$10$TzK1YJ.Twa4rI5uUfZ9WQuSLRDo5qSl7Q6HWXH2s9ohjXduzyFlDe', '2025-04-22 00:31:46', 'agadir ', '+212714719431', 'admin'),
(3, 'sBot', 'aminebigfaine4@gamil.com', '$2y$10$h2C/1k6RFhO.8VMWtKsnOOuNR6S8GkYV8QqwiQd1S2YQoaLUQ9tVK', '2025-05-02 18:00:33', NULL, NULL, 'support');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `product_id`, `created_at`) VALUES
(10, 1, 1, '2025-07-25 00:49:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`name`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
