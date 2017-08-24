Pipeline
========

Pipeline is a library + CLI tool to load programmable pipelines, execute jobs and get detailed results per stage for reporting/debugging.

## Concepts

* Pipeline: A sequential list of stages
* Stage: An command template with a unique name within the pipeline.
* Job: A job that will be executed on a pipeline with an optional set of input variables
* JobResult: The output of a Job that has been executed on a pipeline, contains status and a StageResult for each stage in the pipeline
* StageResult: The exact command that was executed, it's exitcode, stdout and stderr.

## CLI example

    bin/pipeline run examples/demo.pipeline.yml  -d topic=technology

This will load the pipeline defined in `examples/demo.pipeline.yml` and execute it with input variable `topic=technology`

## Library example

Please refer to `examples/example-code.php` on how to use the pipeline package as a library.

## License

MIT. Please refer to the [license file](LICENSE.md) for details.

## Brought to you by the LinkORB Engineering team

<img src="http://www.linkorb.com/d/meta/tier1/images/linkorbengineering-logo.png" width="200px" /><br />
Check out our other projects at [linkorb.com/engineering](http://www.linkorb.com/engineering).

Btw, we're hiring!
