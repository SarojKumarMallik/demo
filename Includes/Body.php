<div>
    <!-- Grid -->
    <div class="w3-row">

        <!-- Blog entries -->
        <div class="w3-col s12" style="display:flex; gap:5px;flex-wrap: wrap;">
            <!-- Blog entry -->
            <?php DisplayPostsIndex(); ?>
            <!-- END BLOG ENTRIES -->
        </div>

        <!-- END GRID -->
    </div>
    <br>
    <style>
        .w3-bar {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 5px 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .w3-bar a {
            text-decoration: none;
            color: rgb(215, 111, 0);
            margin: 0 5px;
            border-radius: 5px;
            border: 1px solid transparent;
            transition: all 0.3s ease;
        }

        .w3-bar a:hover {
            background-color: rgb(215, 111, 0);
            /* Bright blue background on hover */
            color: white;
            /* White text on hover */
            border-color: rgb(215, 111, 0);
            /* Blue border on hover */
            transform: scale(1.05);
            /* Subtle zoom effect */
        }

        .w3-bar .w3-disabled {
            color: #aaa;
            /* Light grey for disabled buttons */
            pointer-events: none;
            /* Prevent interaction */
            background-color: #f0f0f0;
            /* Light grey background */
            border-color: #ddd;
            /* Subtle border */
        }
    </style>
    <div style="display: flex;justify-content: center;padding: 5px;" class="w3-center">
        <div class="w3-bar w3-border w3-round">
            <b><a href="<?php if ($PageNo <= 1) {
                echo "#";
            } else {
                echo "?Page=" . ($PageNo - 1);
            } ?>" class="<?php if ($PageNo <= 1) {
                 echo "w3-disabled";
             } ?> w3-bar-item w3-button">&laquo;</a></b>
            <b><a href="<?php if ($PageNo >= $TotalPages) {
                echo "#";
            } else {
                echo "?Page=" . ($PageNo + 1);
            } ?>" class="<?php if ($PageNo >= $TotalPages) {
                 echo "w3-disabled";
             } ?> w3-button">&raquo;</a></b>
        </div>
    </div>
    <!-- END w3-content -->
</div>