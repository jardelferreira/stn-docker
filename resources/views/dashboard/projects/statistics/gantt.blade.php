<!DOCTYPE html>

<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.dhtmlx.com/gantt/edge/dhtmlxgantt.js"></script>
    <link href="https://cdn.dhtmlx.com/gantt/edge/dhtmlxgantt.css" rel="stylesheet">

    <style type="text/css">
        html,
        body {
            height: 100%;
            padding: 0px;
            margin: 0px;
            overflow: hidden;
        }

        .sabado {
            background: #EEDD82 !important;
        }

        .domingo {
            background: #FFDAB9 !important;
        }

        .gantt_grid_scale,
        .gantt_task_scale,
        .gantt_task_vscroll {
            background-color: #eee;
            border: #000 solid 1px;
            border-spacing: 0;
            border-collapse: collapse;
        }

        .gantt_grid_scale,
        .gantt_task_scale,
        .gantt_task .gantt_task_scale .gantt_scale_cell,
        .gantt_grid_scale .gantt_grid_head_cell {
            color: #000;
            font-size: 12px;
            border: #000 solid 1px;
            border-spacing: 0;
            border-collapse: collapse;
        }

        .gantt_task_line {
            border-color: rgba(0, 0, 0, 0.25);
            /* Black color with 25% alpha/opacity */
        }

        .gantt_task_line .gantt_task_progress {
            background-color: rgba(0, 0, 0, 0.25);
        }

        .gantt_task_line {
            background-color: #03A9F4;
        }

        .gantt_task_line.gantt_task_content {
            color: #fff;
        }

        .gantt_task_progress {
			text-align: left;
			padding-left: 10px;
			box-sizing: border-box;
			color: white;
			font-weight: bold;
		}
    </style>
</head>

<body>
    <div id="gantt_here" style='width:100%; height:100%;'></div>
    <script type="text/javascript">
        gantt.config.min_column_width = 50;
        gantt.config.scale_height = 90;
        var weekScaleTemplate = function(date) {
            var dateToStr = gantt.date.date_to_str("%d %M");
            var endDate = gantt.date.add(gantt.date.add(date, 1, "week"), -1, "day");
            return dateToStr(date) + " - " + dateToStr(endDate);
        };

        var daysStyle = function(date) {
            // you can use gantt.isWorkTime(date)
            // when gantt.config.work_time config is enabled
            // In this sample it's not so we just check week days

            if (date.getDay() === 6) {
                return "sabado";
            }
            if (date.getDay() === 0) {
                return "domingo"
            }
            return "";
        };
        gantt.config.scales = [{
                unit: "month",
                step: 1,
                format: "%F, %Y"
            },
            {
                unit: "week",
                step: 1,
                format: weekScaleTemplate
            },
            {
                unit: "day",
                step: 1,
                format: "%d-%D",
                css: daysStyle
            }
        ];
        gantt.config.date_format = "%Y-%m-%d %H:%i:%s";
        gantt.config.order_branch = true;
        gantt.config.order_branch_free = true;

        gantt.config.fit_tasks = true;

        gantt.i18n.setLocale("pt");

        gantt.locale.labels.section_priority = "Color";
	gantt.locale.labels.section_textColor = "Text Color";

	var colors = [
		{key: "", label: "Default"},
		{key: "#4B0082", label: "Indigo"},
		{key: "#FFFFF0", label: "Ivory"},
		{key: "#F0E68C", label: "Khaki"},
		{key: "#B0C4DE", label: "LightSteelBlue"},
		{key: "#32CD32", label: "LimeGreen"},
		{key: "#7B68EE", label: "MediumSlateBlue"},
		{key: "#FFA500", label: "Orange"},
		{key: "#FF4500", label: "OrangeRed"}
	];

	gantt.config.lightbox.sections = [
		{name: "description", height: 38, map_to: "text", type: "textarea", focus: true},
		{name: "priority", height: 22, map_to: "color", type: "select", options: colors},
		{name: "textColor", height: 22, map_to: "textColor", type: "select", options: colors},
		{name: "time", type: "duration", map_to: "auto"}
	];

    gantt.templates.progress_text = function (start, end, task) {
		return "<span style='text-align:left;'>" + Math.round(task.progress * 100) + "% </span>";
	};
        gantt.init("gantt_here");

        gantt.load("/api/data");

        var dp = new gantt.dataProcessor("/api");
        dp.init(gantt);
        dp.setTransactionMode({
            mode: "REST",
            payload: {
                '_token': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            }
        });
        dp.attachEvent("onAfterUpdate", function(id, action, tid, response) {
            if (action == "error") {
                alert("erro ao executar a tarefa!");
                gantt.clearAll();
                gantt.load("url1");
            }
        });
    </script>
</body>
